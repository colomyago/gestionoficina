<?php

namespace App\Filament\Resources\Equipment\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use Filament\Actions\ActionGroup;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
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
use Illuminate\Support\Facades\DB;
use App\Models\MaintenanceRequest;
use App\Models\AuditLog;

class EquipmentTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->with(['user', 'activeLoan.user']))
            ->columns([
                ImageColumn::make('image')
                    ->label(__('Image'))
                    ->circular()
                    ->defaultImageUrl(url('/images/default-equipment.svg'))
                    ->size(50),
                    
                TextColumn::make('codigo')
                    ->label(__('Code'))
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('categoria')
                    ->label(__('Category'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                    
                BadgeColumn::make('status')
                    ->label(__('Status'))
                    ->colors([
                        'success' => 'disponible',
                        'warning' => 'prestado',
                        'info' => 'mantenimiento',
                        'danger' => 'baja',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'disponible' => __('Available'),
                        'prestado' => __('Loaned'),
                        'mantenimiento' => __('In Maintenance'),
                        'baja' => __('Decommissioned'),
                        default => $state,
                    }),
                    
                TextColumn::make('user.name')
                    ->label(__('User'))
                    ->searchable()
                    ->sortable()
                    ->placeholder(__('Unassigned'))
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('categoria')
                    ->label(__('Category'))
                    ->options([
                        'Computadoras' => __('Computers'),
                        'Laptops' => __('Laptops'),
                        'Tablets' => __('Tablets'),
                        'Monitores' => __('Monitors'),
                        'Impresoras' => __('Printers'),
                        'Audio' => __('Audio'),
                        'Redes' => __('Networks'),
                        'Almacenamiento' => __('Storage'),
                        'Periféricos' => __('Peripherals'),
                        'Proyección' => __('Projection'),
                        'Otros' => __('Others'),
                    ])
                    ->placeholder(__('All categories')),
            ])
            ->recordActions([
                ActionGroup::make([
                    EditAction::make()
                        ->visible(fn (): bool => Auth::user()->isAdmin()),
                    DeleteAction::make()
                        ->visible(fn (): bool => Auth::user()->isAdmin()),
                    
                    // ACCIÓN: Asignar Directamente (solo admin, equipos disponibles)
                    Action::make('asignar')
                        ->label(__('Assign Equipment'))
                        ->icon('heroicon-o-user-plus')
                        ->color('success')
                        ->visible(fn ($record): bool => 
                            Auth::user()->isAdmin() && 
                            $record->status === 'disponible'
                        )
                        ->form([
                            Select::make('user_id')
                                ->label(__('Assign to'))
                                ->options(\App\Models\User::whereHas('role', function ($query) {
                                    $query->where('code', 'trabajador');
                                })->pluck('name', 'id'))
                                ->searchable()
                                ->required()
                                ->helperText(__('Select the worker to assign the device to')),
                            
                            Select::make('periodo_prestamo')
                                ->label(__('Loan Period'))
                                ->options([
                                    '2' => __('2 days'),
                                    '5' => __('5 days (1 work week)'),
                                    '10' => __('10 days'),
                                    '15' => __('15 days (2 weeks)'),
                                    '21' => __('3 weeks'),
                                    '30' => __('30 days (1 month)'),
                                    '45' => __('45 days'),
                                    '90' => __('90 days (3 months)'),
                                    'custom' => __('Custom date...'),
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
                                ->placeholder(__('Reason for assignment, special conditions, etc.'))
                                ->maxLength(500),
                        ])
                        ->action(function ($record, array $data) {
                            // Validar disponibilidad
                            if ($record->status !== 'disponible') {
                                Notification::make()
                                    ->title(__('Device not available'))
                                    ->danger()
                                    ->body(__('The selected device is no longer available.'))
                                    ->send();
                                return;
                            }

                            // Calcular fecha de devolución basada en el período o fecha custom
                            if (isset($data['periodo_prestamo']) && $data['periodo_prestamo'] !== 'custom' && is_numeric($data['periodo_prestamo'])) {
                                $data['fecha_devolucion'] = now()->addDays((int)$data['periodo_prestamo'])->format('Y-m-d');
                            }
                            
                            // Validar fecha custom
                            if (!isset($data['fecha_devolucion']) || empty($data['fecha_devolucion'])) {
                                Notification::make()
                                    ->title(__('Error'))
                                    ->danger()
                                    ->body(__('Return date is required.'))
                                    ->send();
                                return;
                            }

                            // Validar límites usando el servicio
                            $validationService = app(\App\Services\LoanValidationService::class);
                            $user = \App\Models\User::find($data['user_id']);
                            
                            if (!$validationService->canLoanEquipment($user, $record)) {
                                return; // El servicio ya envía la notificación
                            }

                            DB::beginTransaction();
                            try {
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

                                DB::commit();

                                $user = \App\Models\User::find($data['user_id']);

                                Notification::make()
                                    ->title(__('Equipment assigned successfully'))
                                    ->success()
                                    ->body(__('The device has been assigned to :user', ['user' => $user->name]))
                                    ->send();
                            } catch (\Exception $e) {
                                DB::rollBack();
                                Notification::make()
                                    ->title(__('Error'))
                                    ->danger()
                                    ->body(__('An error occurred while assigning the device. Please try again.'))
                                    ->send();
                            }
                        }),
                    
                    // ACCIÓN: Solicitar Préstamo (solo trabajadores, equipos disponibles)
                    Action::make('solicitar')
                        ->label(__('Request Loan'))
                        ->icon('heroicon-o-hand-raised')
                        ->color('primary')
                        ->visible(fn ($record): bool => 
                            Auth::user()->isTrabajador() && 
                            $record->status === 'disponible'
                        )
                        ->form([
                            Textarea::make('motivo')
                                ->label(__('Reason for request'))
                                ->rows(3)
                                ->maxLength(500)
                                ->helperText(__('Explain why you need this device')),
                        ])
                        ->action(function ($record, array $data) {
                            // Validar que el equipo esté disponible (no en baja ni en mantenimiento)
                            if ($record->status !== 'disponible') {
                                Notification::make()
                                    ->title(__('Device not available'))
                                    ->danger()
                                    ->body(__('This device is not available for loan. Current status: :status', ['status' => $record->status]))
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
                                    ->title(__('Duplicate request'))
                                    ->danger()
                                    ->body(__('You already have a :status request for this device.', ['status' => $existingSolicitud->status]))
                                    ->send();
                                return;
                            }

                            DB::beginTransaction();
                            try {
                                Loan::create([
                                    'equipment_id' => $record->id,
                                    'user_id' => Auth::id(),
                                    'status' => 'pendiente',
                                    'fecha_solicitud' => now(),
                                    'motivo' => $data['motivo'],
                                ]);

                                DB::commit();

                                Notification::make()
                                    ->title(__('Request sent'))
                                    ->success()
                                    ->body(__('Your request is pending approval.'))
                                    ->send();
                            } catch (\Exception $e) {
                                DB::rollBack();
                                Notification::make()
                                    ->title(__('Error'))
                                    ->danger()
                                    ->body(__('An error occurred while sending the request. Please try again.'))
                                    ->send();
                            }
                        }),
                    
                    // ACCIÓN: Enviar a Mantenimiento (trabajadores y admin)
                    Action::make('mantenimiento')
                        ->label(__('Send to Maintenance'))
                        ->icon('heroicon-o-wrench-screwdriver')
                        ->color('warning')
                        ->visible(fn ($record): bool => 
                            (Auth::user()->isTrabajador() || Auth::user()->isAdmin()) && 
                            in_array($record->status, ['disponible', 'prestado'])
                        )
                        ->form([
                            Textarea::make('descripcion_problema')
                                ->label(__('Problem description'))
                                ->required()
                                ->rows(3)
                                ->maxLength(1000)
                                ->helperText(__('Describe the device problem')),
                        ])
                        ->action(function ($record, array $data) {
                            DB::beginTransaction();
                            try {
                                $wasPrestado = $record->status === 'prestado';
                                
                                // Si el equipo está prestado, actualizar el loan activo
                                if ($wasPrestado) {
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

                                // Registrar auditoría
                                AuditLog::log(
                                    AuditLog::EQUIPMENT_TO_MAINTENANCE,
                                    $record,
                                    Auth::user(),
                                    ['status' => $wasPrestado ? 'prestado' : 'disponible'],
                                    ['status' => 'mantenimiento'],
                                    "Equipo enviado a mantenimiento: {$data['descripcion_problema']}"
                                );

                                DB::commit();

                                Notification::make()
                                    ->title(__('Device sent to maintenance'))
                                    ->success()
                                    ->body(__('The device has been sent to maintenance.') . 
                                          ($wasPrestado ? ' ' . __('The active loan was automatically ended.') : ''))
                                    ->send();
                            } catch (\Exception $e) {
                                DB::rollBack();
                                Notification::make()
                                    ->title(__('Error'))
                                    ->danger()
                                    ->body(__('An error occurred while reporting the problem. Please try again.'))
                                    ->send();
                            }
                        }),
                ])
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->visible(fn (): bool => Auth::user()->isAdmin())
                        ->before(function ($records) {
                            $equipmentWithLoans = $records->filter(function ($equipment) {
                                return Loan::where('equipment_id', $equipment->id)
                                    ->where('status', 'activo')
                                    ->exists();
                            });

                            if ($equipmentWithLoans->isNotEmpty()) {
                                Notification::make()
                                    ->title(__('Error'))
                                    ->danger()
                                    ->body(__('Cannot delete devices with active loans. Please return them first.'))
                                    ->send();
                                
                                return false;
                            }
                        }),
                ]),
            ])
            ->defaultSort('name', 'asc')
            ->persistFiltersInSession();
    }
}
