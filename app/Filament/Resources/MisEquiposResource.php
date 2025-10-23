<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MisEquiposResource\Pages;
use App\Models\Equipment;
use App\Models\Loan;
use App\Models\MaintenanceRequest;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Textarea;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use BackedEnum;
use Filament\Support\Icons\Heroicon;

class MisEquiposResource extends Resource
{
    protected static ?string $model = Equipment::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedComputerDesktop;

    protected static ?string $navigationLabel = 'Mis Equipos';

    protected static ?string $modelLabel = 'Mi Equipo';

    protected static ?string $pluralModelLabel = 'Mis Equipos';

    protected static ?int $navigationSort = 0;

    // Solo visible para trabajadores
    public static function canViewAny(): bool
    {
        $user = Auth::user();
        return $user && $user->isTrabajador();
    }

    public static function canCreate(): bool
    {
        return false; // No pueden crear equipos
    }

    public static function canEdit($record): bool
    {
        return false; // No pueden editar equipos
    }

    public static function canDelete($record): bool
    {
        return false; // No pueden eliminar equipos
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                // Solo mostrar equipos asignados al usuario actual
                return $query->where('user_id', Auth::id())
                    ->where('status', 'prestado');
            })
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('codigo')
                    ->label('Código')
                    ->searchable()
                    ->badge()
                    ->color('primary'),

                TextColumn::make('categoria')
                    ->label('Categoría')
                    ->searchable()
                    ->sortable(),

                BadgeColumn::make('status')
                    ->label('Estado')
                    ->colors([
                        'warning' => 'prestado',
                        'info' => 'mantenimiento',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'prestado' => 'En mi poder',
                        'mantenimiento' => 'En Mantenimiento',
                        default => $state,
                    }),

                TextColumn::make('fecha_prestado')
                    ->label('Desde')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('fecha_devolucion')
                    ->label('Devolución Estimada')
                    ->date('d/m/Y')
                    ->sortable()
                    ->color(fn ($record) => 
                        $record->fecha_devolucion && $record->fecha_devolucion->isPast() 
                            ? 'danger' 
                            : 'gray'
                    )
                    ->tooltip(fn ($record) => 
                        $record->fecha_devolucion && $record->fecha_devolucion->isPast()
                            ? '⚠️ Fecha vencida'
                            : null
                    ),

                TextColumn::make('description')
                    ->label('Descripción')
                    ->limit(50)
                    ->wrap()
                    ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),

                    // ACCIÓN: Devolver equipo
                    Action::make('devolver')
                        ->label('Devolver Equipo')
                        ->icon('heroicon-o-arrow-uturn-left')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('¿Devolver este equipo?')
                        ->modalDescription(fn ($record) => 
                            'Estás a punto de devolver: ' . $record->name . ' (' . $record->codigo . ')'
                        )
                        ->modalSubmitActionLabel('Sí, devolver')
                        ->action(function ($record) {
                            // Buscar el préstamo activo
                            $activeLoan = Loan::where('equipment_id', $record->id)
                                ->where('user_id', Auth::id())
                                ->where('status', 'activo')
                                ->first();

                            if (!$activeLoan) {
                                Notification::make()
                                    ->title('Error')
                                    ->danger()
                                    ->body('No se encontró un préstamo activo para este equipo.')
                                    ->send();
                                return;
                            }

                            // Actualizar el préstamo
                            $activeLoan->update([
                                'status' => 'devuelto',
                                'fecha_devolucion_real' => now(),
                            ]);

                            // Actualizar el equipo
                            $record->update([
                                'status' => 'disponible',
                                'user_id' => null,
                                'fecha_prestado' => null,
                                'fecha_devolucion' => null,
                            ]);

                            Notification::make()
                                ->title('Equipo devuelto')
                                ->success()
                                ->body('El equipo ha sido marcado como disponible.')
                                ->send();
                        }),

                    // ACCIÓN: Reportar problema (enviar a mantenimiento)
                    Action::make('reportar_problema')
                        ->label('Reportar Problema')
                        ->icon('heroicon-o-exclamation-triangle')
                        ->color('warning')
                        ->form([
                            Textarea::make('descripcion_problema')
                                ->label('Descripción del problema')
                                ->required()
                                ->rows(4)
                                ->maxLength(1000)
                                ->helperText('Describe detalladamente el problema que tiene el equipo')
                                ->placeholder('Ejemplo: La pantalla no enciende, el teclado no responde, etc.'),
                        ])
                        ->action(function ($record, array $data) {
                            // Buscar el préstamo activo
                            $activeLoan = Loan::where('equipment_id', $record->id)
                                ->where('user_id', Auth::id())
                                ->where('status', 'activo')
                                ->first();

                            if ($activeLoan) {
                                // Finalizar el préstamo
                                $activeLoan->update([
                                    'status' => 'devuelto',
                                    'fecha_devolucion_real' => now(),
                                    'notas' => ($activeLoan->notas ? $activeLoan->notas . "\n\n" : '') . 
                                               'Equipo devuelto automáticamente - Enviado a mantenimiento: ' . 
                                               $data['descripcion_problema']
                                ]);
                            }

                            // Crear solicitud de mantenimiento
                            MaintenanceRequest::create([
                                'equipment_id' => $record->id,
                                'requested_by' => Auth::id(),
                                'status' => 'pendiente',
                                'descripcion_problema' => $data['descripcion_problema'],
                                'fecha_solicitud' => now(),
                            ]);

                            // Actualizar el equipo
                            $record->update([
                                'status' => 'mantenimiento',
                                'user_id' => null,
                                'fecha_prestado' => null,
                                'fecha_devolucion' => null,
                            ]);

                            Notification::make()
                                ->title('Problema reportado')
                                ->success()
                                ->body('El equipo ha sido enviado a mantenimiento. Gracias por reportar el problema.')
                                ->send();
                        }),
                ])
            ])
            ->emptyStateHeading('No tienes equipos asignados')
            ->emptyStateDescription('Cuando se te asigne un equipo, aparecerá aquí.')
            ->emptyStateIcon('heroicon-o-computer-desktop')
            ->defaultSort('fecha_prestado', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMisEquipos::route('/'),
            'view' => Pages\ViewMisEquipo::route('/{record}'),
        ];
    }
}
