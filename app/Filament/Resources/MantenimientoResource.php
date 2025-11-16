<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MantenimientoResource\Pages;
use App\Models\MaintenanceRequest;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Placeholder;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Actions\ViewAction;
use Filament\Actions\ActionGroup;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use BackedEnum;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\DB;
use App\Models\Loan;

class MantenimientoResource extends Resource
{
    protected static ?string $model = MaintenanceRequest::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedWrenchScrewdriver;

    protected static ?string $navigationLabel = null;

    protected static ?int $navigationSort = 3;

    public static function getNavigationBadge(): ?string
    {
        $user = Auth::user();
        
        // Mostrar solicitudes pendientes de mantenimiento
        if ($user && ($user->isMantenimiento() || $user->isAdmin())) {
            $count = MaintenanceRequest::where('status', 'pendiente')->count();
            return $count > 0 ? (string) $count : null;
        }
        
        return null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    // Solo visible para personal de mantenimiento y admin
    public static function canViewAny(): bool
    {
        $user = Auth::user();
        return $user && ($user->isMantenimiento() || $user->isAdmin());
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Placeholder::make('equipment.name')
                    ->label(__('Device')) // Equipo
                    ->content(fn ($record) => $record->equipment->name ?? 'N/A'),

                Placeholder::make('equipment.codigo')
                    ->label(__('Code')) // Código
                    ->content(fn ($record) => $record->equipment->codigo ?? 'N/A'),

                Placeholder::make('requestedBy.name')
                    ->label(__('Requested by')) // Solicitado por
                    ->content(fn ($record) => $record->requestedBy->name ?? 'N/A'),

                Placeholder::make('descripcion_problema')
                    ->label(__('Problem description')) // Descripción del Problema
                    ->content(fn ($record) => $record->descripcion_problema ?? 'N/A'),

                Placeholder::make('fecha_solicitud')
                    ->label(__('Request Date')) // Fecha de Solicitud
                    ->content(fn ($record) => $record->fecha_solicitud?->format('d/m/Y H:i') ?? 'N/A'),

                Select::make('assigned_to')
                    ->label(__('Assigned to')) // Asignado a
                    ->options(function () {
                        return \App\Models\User::whereHas('role', function ($query) {
                            $query->where('code', 'mantenimiento');
                        })->pluck('name', 'id');
                    })
                    ->searchable()
                    ->nullable()
                    ->helperText('Técnico responsable'),

                Select::make('status')
                    ->label(__('Status'))
                    ->options([
                        'pendiente' => __('Pending'),
                        'en_proceso' => __('In Progress'),
                        'completado' => __('Completed'),
                        'rechazado' => __('Rejected'),
                    ])
                    ->required(),

                Textarea::make('solucion')
                    ->label(__('Solution')) // Solución
                    ->rows(3)
                    ->maxLength(1000)
                    ->helperText('Describe la solución aplicada'),

                Select::make('resultado')
                    ->label(__('Result'))
                    ->options([
                        'pendiente' => __('Pending'),
                        'reparado' => __('Repaired'),
                        'dado_de_baja' => __('Decommissioned'),
                    ])
                    ->required()
                    ->default('pendiente'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('equipment.name')
                    ->label(__('Device')) // Equipo
                    ->searchable()
                    ->sortable()
                    ->description(fn (MaintenanceRequest $record): string => 
                        $record->equipment->codigo ?? ''
                    ),

                BadgeColumn::make('status')
                        ->label(__('Status'))
                        ->colors([
                            'warning' => 'pendiente',
                            'info' => 'en_proceso',
                            'success' => 'completado',
                            'danger' => 'rechazado',
                        ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pendiente' => __('Pending'),
                        'en_proceso' => __('In Progress'),
                        'completado' => __('Completed'),
                        'rechazado' => __('Rejected'),
                        default => $state,
                    }),

                TextColumn::make('descripcion_problema')
                    ->label(__('Problem')) // Problema
                    ->limit(50)
                    ->tooltip(function (MaintenanceRequest $record): string {
                        return $record->descripcion_problema ?? '';
                    })
                    ->searchable()
                    ->wrap(),

                TextColumn::make('assignedTo.name')
                    ->label(__('Assigned to')) // Asignado a
                    ->placeholder('Sin asignar')
                    ->sortable(),

                TextColumn::make('fecha_solicitud')
                    ->label(__('Request Date')) // Fecha de Solicitud
                    ->dateTime('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                 SelectFilter::make('status')
                    ->label(__('Status'))
                    ->options([
                        'pendiente' => __('Pending'),
                        'en_proceso' => __('In Progress'),
                        'completado' => __('Completed'),
                        'rechazado' => __('Rejected'),
                    ]),


                 SelectFilter::make('resultado')
                    ->label(__('Result'))
                    ->options([
                        'pendiente' => __('Pending'),
                        'reparado' => __('Repaired'),
                        'dado_de_baja' => __('Decommissioned'),
                    ]),
            ])
            ->recordActions([
                ActionGroup::make([
                    Action::make('tomar')
                        ->label(__('Take')) // Tomar
                        ->icon('heroicon-o-hand-raised')
                        ->color('info')
                        ->visible(fn (MaintenanceRequest $record): bool => 
                            $record->status === 'pendiente' && Auth::user()->isMantenimiento()
                        )
                        ->requiresConfirmation()
                        ->action(function (MaintenanceRequest $record) {
                            DB::beginTransaction();
                            try {
                                $record->update([
                                    'status' => 'en_proceso',
                                    'assigned_to' => Auth::id(),
                                ]);

                                DB::commit();

                                Notification::make()
                                    ->title('Solicitud tomada')
                                    ->success()
                                    ->send();
                            } catch (\Exception $e) {
                                DB::rollBack();
                                Notification::make()
                                    ->title('Error')
                                    ->danger()
                                    ->body('Ocurrió un error al tomar la tarea. Intente nuevamente.')
                                    ->send();
                            }
                        }),

                    Action::make('reparar')
                        ->label(__('Mark as Repaired')) // Marcar como Reparado
                        ->icon('heroicon-o-check-badge')
                        ->color('success')
                        ->visible(fn (MaintenanceRequest $record): bool => 
                            in_array($record->status, ['pendiente', 'en_proceso']) && 
                            (Auth::user()->isMantenimiento() || Auth::user()->isAdmin())
                        )
                        ->requiresConfirmation()
                        ->form([
                            Textarea::make('solucion')
                                ->label('Solución Aplicada')
                                ->required()
                                ->rows(3),
                        ])
                        ->action(function (MaintenanceRequest $record, array $data) {
                            DB::beginTransaction();
                            try {
                                $record->update([
                                    'status' => 'completado',
                                    'resultado' => 'reparado',
                                    'solucion' => $data['solucion'],
                                    'fecha_completado' => now(),
                                ]);

                                // Cambiar el equipo a disponible
                                $record->equipment->update([
                                    'status' => 'disponible',
                                ]);

                                DB::commit();

                                Notification::make()
                                    ->title('Equipo reparado y disponible')
                                    ->success()
                                    ->send();
                            } catch (\Exception $e) {
                                DB::rollBack();
                                Notification::make()
                                    ->title('Error')
                                    ->danger()
                                    ->body('Ocurrió un error al marcar como reparado. Intente nuevamente.')
                                    ->send();
                            }
                        }),

                    Action::make('dar_de_baja')
                        ->label(__('Cancel')) // Dar de Baja
                        ->icon('heroicon-o-trash')
                        ->color('danger')
                        ->visible(fn (MaintenanceRequest $record): bool => 
                            in_array($record->status, ['pendiente', 'en_proceso']) && 
                            (Auth::user()->isMantenimiento() || Auth::user()->isAdmin())
                        )
                        ->requiresConfirmation()
                        ->form([
                            Textarea::make('solucion')
                                ->label(__('Cancel reason')) // Motivo de la Baja
                                ->required()
                                ->rows(3)
                                ->helperText('Explica por qué se da de baja el equipo'),
                        ])
                        ->action(function (MaintenanceRequest $record, array $data) {
                            DB::beginTransaction();
                            
                            try {
                                $record->update([
                                    'status' => 'completado',
                                    'resultado' => 'dado_de_baja',
                                    'solucion' => $data['solucion'],
                                    'fecha_completado' => now(),
                                ]);

                                // Cerrar cualquier préstamo activo antes de dar de baja
                                $activeLoan = Loan::where('equipment_id', $record->equipment_id)
                                    ->where('status', 'activo')
                                    ->first();
                                
                                if ($activeLoan) {
                                    $activeLoan->update([
                                        'status' => 'devuelto',
                                        'fecha_devolucion_real' => now(),
                                        'notas' => ($activeLoan->notas ? $activeLoan->notas . "\n\n" : '') .
                                                   'Préstamo finalizado automáticamente - Equipo dado de baja: ' . $data['solucion']
                                    ]);
                                }

                                // Marcar el equipo como dado de baja
                                $record->equipment->update([
                                    'status' => 'baja',
                                    'user_id' => null,
                                ]);
                                
                                DB::commit();

                                Notification::make()
                                    ->title('Equipo dado de baja')
                                    ->warning()
                                    ->body($activeLoan ? 'El préstamo activo fue cerrado automáticamente' : null)
                                    ->send();
                                    
                            } catch (\Exception $e) {
                                DB::rollBack();
                                Notification::make()
                                    ->title('Error')
                                    ->danger()
                                    ->body('Ocurrió un error: ' . $e->getMessage())
                                    ->send();
                            }
                        }),

                    EditAction::make()
                        ->visible(fn (): bool => Auth::user()->isAdmin()),
                ])
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    //
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getLabel(): string
    {
        return __('Maintenance');  
    }

    public static function getPluralLabel(): string
    {
        return __('Maintenance');
    }

    public static function getNavigationLabel(): string
    {
        return __('Maintenance');
    }

    public static function getModelLabel(): string
    {
        return __('Maintenance Request'); // singular
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMantenimientos::route('/'),
            'view' => Pages\ViewMantenimiento::route('/{record}'),
            'edit' => Pages\EditMantenimiento::route('/{record}/edit'),
        ];
    }
}
