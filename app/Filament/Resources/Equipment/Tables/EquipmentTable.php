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
                    
                TextColumn::make('fecha_prestado')
                    ->label('F. Préstamo')
                    ->date('d/m/Y')
                    ->sortable()
                    ->placeholder('-'),
                    
                TextColumn::make('fecha_devolucion')
                    ->label('F. Devolución')
                    ->date('d/m/Y')
                    ->sortable()
                    ->placeholder('-'),
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
                                ->maxLength(500),
                            DatePicker::make('fecha_devolucion')
                                ->label('Fecha estimada de devolución')
                                ->required()
                                ->minDate(now()->addDay()),
                        ])
                        ->action(function ($record, array $data) {
                            Loan::create([
                                'equipment_id' => $record->id,
                                'user_id' => Auth::id(),
                                'status' => 'pendiente',
                                'fecha_solicitud' => now(),
                                'fecha_devolucion' => $data['fecha_devolucion'],
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
