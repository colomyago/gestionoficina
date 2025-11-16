<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\ActionGroup;
use STS\FilamentImpersonate\Actions\Impersonate;
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
                    ->getStateUsing(fn ($record) => $record->activeLoans()->count())
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
            ActionGroup::make([    
                EditAction::make(),
                Impersonate::make()
                ->color('primary')
                ->redirectTo('/admin')
                ->visible(fn ($record): bool => Auth::user()->isAdmin() && $record->id !== Auth::id()),
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
                        
                        Select::make('periodo_prestamo')
                            ->label(__('Loan Period'))
                            ->options([
                                '2' => '2 ' . __('days'),
                                '5' => '5 ' . __('days') . ' (1 ' . __('work week') . ')',
                                '10' => '10 ' . __('days'),
                                '15' => '15 ' . __('days') . ' (2 ' . __('weeks') . ')',
                                '21' => '3 ' . __('weeks'),
                                '30' => '30 ' . __('days') . ' (1 ' . __('month') . ')',
                                '45' => '45 ' . __('days'),
                                '90' => '90 ' . __('days') . ' (3 ' . __('months') . ')',
                                'custom' => __('Custom date') . '...',
                            ])
                            ->default('10')
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state !== 'custom' && is_numeric($state)) {
                                    $set('fecha_devolucion', now()->addDays((int)$state)->format('Y-m-d'));
                                }
                            }),
                        
                        DatePicker::make('fecha_devolucion')
                            ->label(__('Exact Date'))
                            ->minDate(now()->addDay())
                            ->required()
                            ->visible(fn ($get) => $get('periodo_prestamo') === 'custom')
                            ->helperText(__('Select a specific date'))
                            ->default(now()->addWeek())
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->format('Y-m-d'),
                        
                        Textarea::make('notas')
                            ->label(__('Notes'))
                            ->rows(2)
                            ->placeholder(__('Assignment reason, special conditions, etc.'))
                            ->maxLength(500),
                    ])
                    ->action(function ($record, array $data) {
                        // Calcular fecha de devolución basada en el período o fecha custom
                        if (isset($data['periodo_prestamo']) && $data['periodo_prestamo'] !== 'custom' && is_numeric($data['periodo_prestamo'])) {
                            $data['fecha_devolucion'] = now()->addDays((int)$data['periodo_prestamo'])->format('Y-m-d');
                        }
                        
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
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}