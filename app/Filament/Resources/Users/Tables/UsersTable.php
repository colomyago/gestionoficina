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
                    ->label(__('Name'))
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('email')
                    ->label(__('Email')) 
                    ->searchable(),
                
                TextColumn::make('role.name')
                    ->label(__('Role'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Administrador' => 'danger',
                        'Trabajador' => 'success',
                        'Mantenimiento' => 'warning',
                        default => 'gray',
                    }),
                
                TextColumn::make('activeLoans')
                    ->label(__('Active loans'))
                    ->counts('activeLoans')
                    ->badge()
                    ->color('primary')
                    ->tooltip(__('Number of devices currently on loan')),
                
                TextColumn::make('email_verified_at')
                    ->label(__('Email verified at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                TextColumn::make('created_at')
                    ->label(__('Created at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                TextColumn::make('updated_at')
                    ->label(__('Updated at'))
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
                    ->label(__('Assign Device'))
                    ->icon('heroicon-o-computer-desktop')
                    ->color('primary')
                    ->visible(fn ($record): bool => 
                        Auth::user()->isAdmin() && 
                        $record->hasRole('trabajador')
                    )
                    ->form([
                        Select::make('equipment_id')
                            ->label(__('Device'))
                            ->options(Equipment::where('status', 'disponible')
                                ->get()
                                ->mapWithKeys(fn ($equipment) => [
                                    $equipment->id => $equipment->name . ' (' . $equipment->codigo . ')'
                                ]))
                            ->searchable()
                            ->required()
                            ->helperText(__('Only available devices are shown')),
                        
                        DatePicker::make('fecha_devolucion')
                            ->label(__('Estimated return date'))
                            ->minDate(now()->addDay())
                            ->required()
                            ->default(now()->addWeek())
                            ->helperText(__('When should the device be returned?')),
                        
                        Textarea::make('notas')
                            ->label(__('Notes'))
                            ->rows(2)
                            ->placeholder(__('Assignment reason, special conditions, etc.'))
                            ->maxLength(500),
                    ])
                    ->action(function ($record, array $data) {
                        $equipment = Equipment::find($data['equipment_id']);
                        
                        // Verificar disponibilidad
                        if ($equipment->status !== 'disponible') {
                            Notification::make()
                                ->title(__('Device not available'))
                                ->danger()
                                ->body(__('The selected device is no longer available.'))
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
                            'motivo' => __('Direct assignment by administrator'),
                            'notas' => $data['notas'] ?? null,
                        ]);

                        // Actualizar el equipo
                        $equipment->update([
                            'status' => 'prestado',
                            'user_id' => $record->id,
                        ]);

                        Notification::make()
                            ->title(__('Device assigned successfully'))
                            ->success()
                            ->body($equipment->name . ' ' . __('has been assigned to') . ' ' . $record->name)
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