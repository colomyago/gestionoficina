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
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Placeholder;
use Filament\Schemas\Schema;
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

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Placeholder::make('info')
                    ->label(__('Device info'))
                    ->content('Detalles del equipo asignado')
                    ->columnSpanFull(),

                TextInput::make('name')
                    ->label(__('Name'))
                    ->disabled(),

                TextInput::make('codigo')
                    ->label(__('Code'))
                    ->disabled(),

                TextInput::make('categoria')
                    ->label(__('Category'))
                    ->disabled(),

                Textarea::make('description')
                    ->label(__('Description'))
                    ->disabled()
                    ->columnSpanFull(),

                Placeholder::make('loan_info')
                    ->label(__('Loan Info'))
                    ->content(fn ($record) => 
                        $record->activeLoan 
                            ? 'Préstamo desde: ' . $record->activeLoan->fecha_prestamo?->format('d/m/Y H:i') . 
                              ' | Devolución estimada: ' . $record->activeLoan->fecha_devolucion?->format('d/m/Y')
                            : 'Sin préstamo activo'
                    )
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                // Mostrar equipos que tienen un préstamo activo del usuario actual
                // Esto incluye equipos en estado 'prestado' y 'mantenimiento'
                return $query->whereHas('activeLoan', function ($loanQuery) {
                    $loanQuery->where('user_id', Auth::id())
                              ->where('status', 'activo');
                });
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
                        'success' => 'prestado',
                        'warning' => 'mantenimiento',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'prestado' => 'En Uso',
                        'mantenimiento' => 'En Mantenimiento',
                        default => $state,
                    }),

                TextColumn::make('activeLoan.fecha_prestamo')
                    ->label('Desde')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->placeholder('-'),

                TextColumn::make('activeLoan.fecha_devolucion')
                    ->label('Devolución Estimada')
                    ->date('d/m/Y')
                    ->sortable()
                    ->color(fn ($record) => 
                        $record->activeLoan && $record->activeLoan->fecha_devolucion && $record->activeLoan->fecha_devolucion->isPast() 
                            ? 'danger' 
                            : 'gray'
                    )
                    ->tooltip(fn ($record) => 
                        $record->activeLoan && $record->activeLoan->fecha_devolucion && $record->activeLoan->fecha_devolucion->isPast()
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

                    // ACCIÓN: Devolver equipo (solo si está prestado)
                    Action::make('devolver')
                        ->label('Devolver Equipo')
                        ->icon('heroicon-o-arrow-uturn-left')
                        ->color('success')
                        ->visible(fn ($record): bool => $record->status === 'prestado')
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
                            ]);

                            Notification::make()
                                ->title('Equipo devuelto')
                                ->success()
                                ->body('El equipo ha sido marcado como disponible.')
                                ->send();
                        }),

                    // ACCIÓN: Reportar problema (solo si está prestado, no en mantenimiento)
                    Action::make('reportar_problema')
                        ->label('Reportar Problema')
                        ->icon('heroicon-o-exclamation-triangle')
                        ->color('warning')
                        ->visible(fn ($record): bool => $record->status === 'prestado')
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
            ->emptyStateDescription('Cuando se te asigne un equipo, aparecerá aquí. Los equipos se mostrarán tanto si están en tu poder como si están en mantenimiento.')
            ->emptyStateIcon('heroicon-o-computer-desktop')
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMisEquipos::route('/'),
            'view' => Pages\ViewMisEquipo::route('/{record}'),
        ];
    }
}
