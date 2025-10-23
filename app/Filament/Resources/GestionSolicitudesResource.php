<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GestionSolicitudesResource\Pages;
use App\Models\Loan;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
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

class GestionSolicitudesResource extends Resource
{
    protected static ?string $model = Loan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?string $navigationLabel = 'Gestión de Préstamos';

    protected static ?string $modelLabel = 'Solicitud';

    protected static ?string $pluralModelLabel = 'Gestión de Préstamos';

    protected static ?int $navigationSort = 2;

    // Solo visible para admin
    public static function canViewAny(): bool
    {
        $user = Auth::user();
        return $user && $user->isAdmin();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Placeholder::make('user.name')
                    ->label('Solicitante')
                    ->content(fn ($record) => $record->user->name ?? 'N/A'),

                Placeholder::make('equipment.name')
                    ->label('Equipo')
                    ->content(fn ($record) => $record->equipment->name ?? 'N/A'),

                Placeholder::make('motivo')
                    ->label('Motivo')
                    ->content(fn ($record) => $record->motivo ?? 'N/A'),

                Placeholder::make('fecha_solicitud')
                    ->label('Fecha de Solicitud')
                    ->content(fn ($record) => $record->fecha_solicitud?->format('d/m/Y') ?? 'N/A'),

                Placeholder::make('fecha_prestamo')
                    ->label('Fecha y Hora de Préstamo')
                    ->content(fn ($record) => $record->fecha_prestamo?->format('d/m/Y H:i') ?? 'No aprobado aún')
                    ->helperText('Fecha automática de cuando se aprobó'),

                Select::make('status')
                    ->label('Estado')
                    ->options([
                        'pendiente' => 'Pendiente',
                        'rechazado' => 'Rechazado',
                        'activo' => 'Activo',
                        'devuelto' => 'Devuelto',
                    ])
                    ->required(),

                DatePicker::make('fecha_devolucion')
                    ->label('Fecha de Devolución Estimada')
                    ->required(fn ($get) => $get('status') === 'activo')
                    ->helperText('Fecha en que debe devolver el equipo'),

                Textarea::make('notas')
                    ->label('Notas del Administrador')
                    ->rows(3)
                    ->maxLength(500)
                    ->helperText('Agrega notas sobre la solicitud'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Solicitante')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('equipment.name')
                    ->label('Equipo')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('equipment.codigo')
                    ->label('Código')
                    ->searchable(),

                BadgeColumn::make('status')
                    ->label('Estado')
                    ->colors([
                        'warning' => 'pendiente',
                        'danger' => 'rechazado',
                        'primary' => 'activo',
                        'secondary' => 'devuelto',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pendiente' => 'Pendiente',
                        'rechazado' => 'Rechazado',
                        'activo' => 'Activo',
                        'devuelto' => 'Devuelto',
                        default => $state,
                    }),

                TextColumn::make('fecha_solicitud')
                    ->label('F. Solicitud')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('fecha_prestamo')
                    ->label('F. Préstamo')
                    ->dateTime('d/m/Y H:i')
                    ->placeholder('N/A')
                    ->tooltip('Fecha y hora de aprobación'),

                TextColumn::make('fecha_devolucion')
                    ->label('F. Dev. Estimada')
                    ->date('d/m/Y')
                    ->placeholder('N/A'),

                TextColumn::make('fecha_devolucion_real')
                    ->label('F. Dev. Real')
                    ->date('d/m/Y')
                    ->placeholder('-')
                    ->color(fn ($record) => $record->fecha_devolucion_real ? 'success' : 'gray'),

                TextColumn::make('motivo')
                    ->label('Motivo')
                    ->limit(30)
                    ->wrap(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Estado')
                    ->options([
                        'pendiente' => 'Pendiente',
                        'rechazado' => 'Rechazado',
                        'activo' => 'Activo',
                        'devuelto' => 'Devuelto',
                    ])
                    ->default('pendiente'),
            ])
            ->recordActions([
                ViewAction::make(),
                
                Action::make('aprobar')
                    ->label('Aprobar')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (Loan $record): bool => $record->status === 'pendiente')
                    ->requiresConfirmation()
                    ->fillForm(fn (Loan $record): array => [
                        'motivo_original' => $record->motivo,
                    ])
                    ->form([
                        Placeholder::make('motivo_original')
                            ->label('Motivo de la Solicitud')
                            ->content(fn (Loan $record): string => $record->motivo ?? 'Sin motivo')
                            ->columnSpanFull(),
                        
                        Placeholder::make('info_fecha_prestamo')
                            ->label('Fecha y Hora de Préstamo')
                            ->content('Se registrará automáticamente al aprobar')
                            ->helperText('El sistema registrará la fecha y hora exacta de aprobación'),
                        
                        DatePicker::make('fecha_devolucion')
                            ->label('Fecha Estimada de Devolución')
                            ->minDate(now()->addDay())
                            ->required()
                            ->helperText('¿Cuándo debe devolver el equipo?')
                            ->default(now()->addWeek()),
                        
                        Textarea::make('notas')
                            ->label('Notas del Admin')
                            ->rows(2)
                            ->placeholder('Condiciones especiales, observaciones, etc.')
                            ->columnSpanFull(),
                    ])
                    ->action(function (Loan $record, array $data) {
                        // Validar que el equipo esté disponible
                        $record->load('equipment');
                        
                        if ($record->equipment->status !== 'disponible') {
                            Notification::make()
                                ->title('Equipo no disponible')
                                ->danger()
                                ->body('El equipo no está disponible. Estado actual: ' . $record->equipment->status)
                                ->send();
                            return;
                        }

                        // Verificar que no haya otro préstamo activo para este equipo
                        $otherActiveLoan = Loan::where('equipment_id', $record->equipment_id)
                            ->where('id', '!=', $record->id)
                            ->where('status', 'activo')
                            ->first();

                        if ($otherActiveLoan) {
                            Notification::make()
                                ->title('Equipo ya prestado')
                                ->danger()
                                ->body('Este equipo ya tiene un préstamo activo para ' . $otherActiveLoan->user->name)
                                ->send();
                            return;
                        }

                        // Fecha de préstamo automática con fecha y hora actual
                        $fechaPrestamoAhora = now();

                        $record->update([
                            'status' => 'activo',
                            'fecha_prestamo' => $fechaPrestamoAhora,
                            'fecha_devolucion' => $data['fecha_devolucion'],
                            'notas' => $data['notas'] ?? null,
                            'assigned_by' => Auth::id(),
                        ]);

                        // Actualizar el equipo con las fechas
                        $record->equipment->update([
                            'status' => 'prestado',
                            'user_id' => $record->user_id,
                            'fecha_prestado' => $fechaPrestamoAhora->toDateString(),
                            'fecha_devolucion' => $data['fecha_devolucion'],
                        ]);

                        Notification::make()
                            ->title('Solicitud aprobada')
                            ->success()
                            ->body('El equipo ha sido asignado a ' . $record->user->name . ' el ' . $fechaPrestamoAhora->format('d/m/Y H:i'))
                            ->send();
                    }),

                Action::make('rechazar')
                    ->label('Rechazar')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn (Loan $record): bool => $record->status === 'pendiente')
                    ->requiresConfirmation()
                    ->modalDescription(fn (Loan $record): string => 
                        'Vas a rechazar la solicitud de ' . $record->user->name . 
                        ' para el equipo ' . $record->equipment->name)
                    ->form([
                        Placeholder::make('motivo_original')
                            ->label('Motivo de la Solicitud')
                            ->content(fn (Loan $record): string => $record->motivo ?? 'Sin motivo')
                            ->columnSpanFull(),
                        
                        Textarea::make('notas')
                            ->label('Motivo del Rechazo')
                            ->required()
                            ->rows(3)
                            ->placeholder('Explica por qué se rechaza esta solicitud')
                            ->columnSpanFull(),
                    ])
                    ->action(function (Loan $record, array $data) {
                        $record->update([
                            'status' => 'rechazado',
                            'notas' => $data['notas'],
                        ]);

                        Notification::make()
                            ->title('Solicitud rechazada')
                            ->danger()
                            ->body('Se ha notificado al usuario sobre el rechazo.')
                            ->send();
                    }),

                EditAction::make()
                    ->visible(fn (Loan $record): bool => $record->status === 'activo'),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGestionSolicitudes::route('/'),
            'view' => Pages\ViewGestionSolicitud::route('/{record}'),
            'edit' => Pages\EditGestionSolicitud::route('/{record}/edit'),
        ];
    }
}
