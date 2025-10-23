<?php

namespace App\Filament\Resources\Equipment\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Table;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use App\Models\Loan;
use App\Models\MaintenanceRequest;

class EquipmentTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('codigo')
                    ->label('Código')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('categoria')
                    ->label('Categoría')
                    ->searchable()
                    ->sortable(),
                    
                BadgeColumn::make('status')
                    ->label('Estado')
                    ->colors([
                        'success' => 'disponible',
                        'warning' => 'prestado',
                        'info' => 'mantenimiento',
                        'danger' => 'baja',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'disponible' => 'Disponible',
                        'prestado' => 'Prestado',
                        'mantenimiento' => 'Mantenimiento',
                        'baja' => 'Dado de Baja',
                        default => $state,
                    }),
                    
                TextColumn::make('user.name')
                    ->label('Usuario')
                    ->searchable()
                    ->sortable()
                    ->placeholder('Sin asignar'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make()
                        ->visible(fn (): bool => Auth::user()->isAdmin()),
                    DeleteAction::make()
                        ->visible(fn (): bool => Auth::user()->isAdmin()),
                    
                    // ACCIÓN: Asignar Directamente (solo admin, equipos disponibles)
                    Action::make('asignar')
                        ->label('Asignar Equipo')
                        ->icon('heroicon-o-user-plus')
                        ->color('success')
                        ->visible(fn ($record): bool => 
                            Auth::user()->isAdmin() && 
                            $record->status === 'disponible'
                        )
                        ->form([
                            Select::make('user_id')
                                ->label('Asignar a')
                                ->options(\App\Models\User::whereHas('role', function ($query) {
                                    $query->where('code', 'trabajador');
                                })->pluck('name', 'id'))
                                ->searchable()
                                ->required()
                                ->helperText('Selecciona el trabajador al que se asignará el equipo'),
                            
                            DatePicker::make('fecha_devolucion')
                                ->label('Fecha Estimada de Devolución')
                                ->minDate(now()->addDay())
                                ->required()
                                ->default(now()->addWeek())
                                ->helperText('¿Cuándo debe devolver el equipo?'),
                            
                            Textarea::make('notas')
                                ->label('Notas')
                                ->rows(2)
                                ->placeholder('Motivo de la asignación, condiciones especiales, etc.')
                                ->maxLength(500),
                        ])
                        ->action(function ($record, array $data) {
                            // Crear el préstamo directamente como activo
                            $loan = Loan::create([
                                'equipment_id' => $record->id,
                                'user_id' => $data['user_id'],
                                'assigned_by' => Auth::id(),
                                'status' => 'activo',
                                'fecha_solicitud' => now(),
                                'fecha_prestamo' => now(),
                                'fecha_devolucion' => $data['fecha_devolucion'],
                                'motivo' => 'Asignación directa por administrador',
                                'notas' => $data['notas'] ?? null,
                            ]);

                            // Actualizar el equipo
                            $record->update([
                                'status' => 'prestado',
                                'user_id' => $data['user_id'],
                            ]);

                            $user = \App\Models\User::find($data['user_id']);

                            Notification::make()
                                ->title('Equipo asignado exitosamente')
                                ->success()
                                ->body('El equipo ha sido asignado a ' . $user->name)
                                ->send();
                        }),
                    
                    // ACCIÓN: Solicitar Préstamo (solo trabajadores, equipos disponibles)
                    Action::make('solicitar')
                        ->label('Solicitar Préstamo')
                        ->icon('heroicon-o-hand-raised')
                        ->color('primary')
                        ->visible(fn ($record): bool => 
                            Auth::user()->isTrabajador() && 
                            $record->status === 'disponible'
                        )
                        ->form([
                            Textarea::make('motivo')
                                ->label('Motivo de la solicitud')
                                ->required()
                                ->rows(3)
                                ->maxLength(500)
                                ->helperText('Explica por qué necesitas este equipo'),
                        ])
                        ->action(function ($record, array $data) {
                            // Validar que el equipo esté disponible (no en baja ni en mantenimiento)
                            if ($record->status !== 'disponible') {
                                Notification::make()
                                    ->title('Equipo no disponible')
                                    ->danger()
                                    ->body('Este equipo no está disponible para préstamo. Estado actual: ' . $record->status)
                                    ->send();
                                return;
                            }

                            // Validar que no exista una solicitud pendiente o activa
                            $existingSolicitud = Loan::where('equipment_id', $record->id)
                                ->where('user_id', Auth::id())
                                ->whereIn('status', ['pendiente', 'activo'])
                                ->first();

                            if ($existingSolicitud) {
                                Notification::make()
                                    ->title('Solicitud duplicada')
                                    ->danger()
                                    ->body('Ya tienes una solicitud ' . $existingSolicitud->status . ' para este equipo.')
                                    ->send();
                                return;
                            }

                            Loan::create([
                                'equipment_id' => $record->id,
                                'user_id' => Auth::id(),
                                'status' => 'pendiente',
                                'fecha_solicitud' => now(),
                                'motivo' => $data['motivo'],
                            ]);

                            Notification::make()
                                ->title('Solicitud enviada')
                                ->success()
                                ->body('Tu solicitud está pendiente de aprobación.')
                                ->send();
                        }),
                    
                    // ACCIÓN: Enviar a Mantenimiento (trabajadores y admin)
                    Action::make('mantenimiento')
                        ->label('Enviar a Mantenimiento')
                        ->icon('heroicon-o-wrench-screwdriver')
                        ->color('warning')
                        ->visible(fn ($record): bool => 
                            (Auth::user()->isTrabajador() || Auth::user()->isAdmin()) && 
                            in_array($record->status, ['disponible', 'prestado'])
                        )
                        ->form([
                            Textarea::make('descripcion_problema')
                                ->label('Descripción del problema')
                                ->required()
                                ->rows(3)
                                ->maxLength(1000)
                                ->helperText('Describe el problema del equipo'),
                        ])
                        ->action(function ($record, array $data) {
                            // Si el equipo está prestado, actualizar el loan activo
                            if ($record->status === 'prestado') {
                                $activeLoan = Loan::where('equipment_id', $record->id)
                                    ->where('status', 'activo')
                                    ->first();

                                if ($activeLoan) {
                                    $activeLoan->update([
                                        'status' => 'devuelto',
                                        'fecha_devolucion_real' => now(),
                                        'notas' => ($activeLoan->notas ? $activeLoan->notas . "\n\n" : '') . 
                                                   'Equipo devuelto automáticamente - Enviado a mantenimiento: ' . 
                                                   $data['descripcion_problema']
                                    ]);
                                }
                            }

                            MaintenanceRequest::create([
                                'equipment_id' => $record->id,
                                'requested_by' => Auth::id(),
                                'status' => 'pendiente',
                                'descripcion_problema' => $data['descripcion_problema'],
                                'fecha_solicitud' => now(),
                            ]);

                            $record->update([
                                'status' => 'mantenimiento',
                                'user_id' => null,
                            ]);

                            Notification::make()
                                ->title('Equipo enviado a mantenimiento')
                                ->success()
                                ->body('El equipo ha sido enviado a mantenimiento.' . 
                                      ($record->status === 'prestado' ? ' El préstamo activo fue finalizado automáticamente.' : ''))
                                ->send();
                        }),
                ])
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->visible(fn (): bool => Auth::user()->isAdmin()),
                ]),
            ]);
    }
}
