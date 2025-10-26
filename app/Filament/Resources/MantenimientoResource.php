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
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use BackedEnum;
use Filament\Support\Icons\Heroicon;

class MantenimientoResource extends Resource
{
    protected static ?string $model = MaintenanceRequest::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedWrenchScrewdriver;

    protected static ?string $navigationLabel = 'Mantenimiento';

    protected static ?string $modelLabel = 'Solicitud de Mantenimiento';

    protected static ?string $pluralModelLabel = 'Mantenimiento';

    protected static ?int $navigationSort = 3;

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
                    ->sortable(),

                TextColumn::make('equipment.codigo')
                    ->label(__('Code')) // Código
                    ->searchable(),

                TextColumn::make('requestedBy.name')
                    ->label(__('Requested by'))//Solicitado por
                    ->searchable(),

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

                BadgeColumn::make('resultado')
                     ->label(__('Result'))
                    ->colors([
                        'secondary' => 'pendiente',
                        'success' => 'reparado',
                        'danger' => 'dado_de_baja',
                    ])
                      ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pendiente' => __('Pending'),
                        'reparado' => __('Repaired'),
                        'dado_de_baja' => __('Decommissioned'),
                        default => $state,
                    }),

                TextColumn::make('assignedTo.name')
                    ->label(__('Assigned to')) // Asignado a
                    ->placeholder('Sin asignar'),

                TextColumn::make('fecha_solicitud')
                    ->label(__('Request Date')) // Fecha de Solicitud
                    ->dateTime('d/m/Y')
                    ->sortable(),

                TextColumn::make('descripcion_problema')
                    ->label(__('Problem')) // Problema
                    ->limit(30)
                    ->wrap(),
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
                ViewAction::make(),

                Action::make('tomar')
                    ->label(__('Take')) // Tomar
                    ->icon('heroicon-o-hand-raised')
                    ->color('info')
                    ->visible(fn (MaintenanceRequest $record): bool => 
                        $record->status === 'pendiente' && Auth::user()->isMantenimiento()
                    )
                    ->requiresConfirmation()
                    ->action(function (MaintenanceRequest $record) {
                        $record->update([
                            'status' => 'en_proceso',
                            'assigned_to' => Auth::id(),
                        ]);

                        Notification::make()
                            ->title('Solicitud tomada')
                            ->success()
                            ->send();
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

                        Notification::make()
                            ->title('Equipo reparado y disponible')
                            ->success()
                            ->send();
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
                        $record->update([
                            'status' => 'completado',
                            'resultado' => 'dado_de_baja',
                            'solucion' => $data['solucion'],
                            'fecha_completado' => now(),
                        ]);

                        // Marcar el equipo como dado de baja
                        $record->equipment->update([
                            'status' => 'baja',
                        ]);

                        Notification::make()
                            ->title('Equipo dado de baja')
                            ->warning()
                            ->send();
                    }),

                EditAction::make()
                    ->visible(fn (): bool => Auth::user()->isAdmin()),
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



    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMantenimientos::route('/'),
            'view' => Pages\ViewMantenimiento::route('/{record}'),
            'edit' => Pages\EditMantenimiento::route('/{record}/edit'),
        ];
    }
}
