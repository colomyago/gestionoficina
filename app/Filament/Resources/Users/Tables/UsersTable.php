<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use App\Models\Equipment;
use App\Models\Loan;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                
                TextColumn::make('role.name')
                    ->label('Rol')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Administrador' => 'danger',
                        'Trabajador' => 'success',
                        'Mantenimiento' => 'warning',
                        default => 'gray',
                    }),
                
                TextColumn::make('activeLoans')
                    ->label('Equipos Activos')
                    ->counts('activeLoans')
                    ->badge()
                    ->color('primary')
                    ->tooltip('Cantidad de equipos prestados actualmente'),
                
                TextColumn::make('email_verified_at')
                    ->label('Email verificado en')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                
                Action::make('asignar_equipo')
                    ->label('Asignar Equipo')
                    ->icon('heroicon-o-computer-desktop')
                    ->color('primary')
                    ->visible(fn ($record): bool => 
                        Auth::user()->isAdmin() && 
                        $record->hasRole('trabajador')
                    )
                    ->form([
                        Select::make('equipment_id')
                            ->label('Equipo')
                            ->options(Equipment::where('status', 'disponible')
                                ->get()
                                ->mapWithKeys(fn ($equipment) => [
                                    $equipment->id => $equipment->name . ' (' . $equipment->codigo . ')'
                                ]))
                            ->searchable()
                            ->required()
                            ->helperText('Solo se muestran equipos disponibles'),
                        
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
                        $equipment = Equipment::find($data['equipment_id']);
                        
                        // Verificar disponibilidad
                        if ($equipment->status !== 'disponible') {
                            Notification::make()
                                ->title('Equipo no disponible')
                                ->danger()
                                ->body('El equipo seleccionado ya no está disponible.')
                                ->send();
                            return;
                        }

                        // Crear el préstamo
                        Loan::create([
                            'equipment_id' => $data['equipment_id'],
                            'user_id' => $record->id,
                            'assigned_by' => Auth::id(),
                            'status' => 'activo',
                            'fecha_solicitud' => now(),
                            'fecha_prestamo' => now(),
                            'fecha_devolucion' => $data['fecha_devolucion'],
                            'motivo' => 'Asignación directa por administrador',
                            'notas' => $data['notas'] ?? null,
                        ]);

                        // Actualizar el equipo
                        $equipment->update([
                            'status' => 'prestado',
                            'user_id' => $record->id,
                            'fecha_prestado' => now()->toDateString(),
                            'fecha_devolucion' => $data['fecha_devolucion'],
                        ]);

                        Notification::make()
                            ->title('Equipo asignado exitosamente')
                            ->success()
                            ->body($equipment->name . ' ha sido asignado a ' . $record->name)
                            ->send();
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
