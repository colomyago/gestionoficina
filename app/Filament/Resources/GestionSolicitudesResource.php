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

                Select::make('status')
                    ->label('Estado')
                    ->options([
                        'pendiente' => 'Pendiente',
                        'aprobado' => 'Aprobado',
                        'rechazado' => 'Rechazado',
                        'activo' => 'Activo',
                        'devuelto' => 'Devuelto',
                    ])
                    ->required(),

                DatePicker::make('fecha_prestamo')
                    ->label('Fecha de Préstamo')
                    ->required(fn ($get) => $get('status') === 'aprobado' || $get('status') === 'activo'),

                DatePicker::make('fecha_devolucion')
                    ->label('Fecha de Devolución Estimada'),

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
                        'success' => 'aprobado',
                        'danger' => 'rechazado',
                        'primary' => 'activo',
                        'secondary' => 'devuelto',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pendiente' => 'Pendiente',
                        'aprobado' => 'Aprobado',
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
                    ->date('d/m/Y')
                    ->placeholder('N/A'),

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
                        'aprobado' => 'Aprobado',
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
                    ->form([
                        DatePicker::make('fecha_prestamo')
                            ->label('Fecha de Préstamo')
                            ->default(now())
                            ->required(),
                        DatePicker::make('fecha_devolucion')
                            ->label('Fecha de Devolución Estimada')
                            ->required(),
                        Textarea::make('notas')
                            ->label('Notas')
                            ->rows(2),
                    ])
                    ->action(function (Loan $record, array $data) {
                        $record->update([
                            'status' => 'activo',
                            'fecha_prestamo' => $data['fecha_prestamo'],
                            'fecha_devolucion' => $data['fecha_devolucion'],
                            'notas' => $data['notas'] ?? null,
                            'assigned_by' => Auth::id(),
                        ]);

                        // Actualizar el equipo con las fechas
                        $record->equipment->update([
                            'status' => 'prestado',
                            'user_id' => $record->user_id,
                            'fecha_prestado' => $data['fecha_prestamo'],
                            'fecha_devolucion' => $data['fecha_devolucion'],
                        ]);

                        Notification::make()
                            ->title('Solicitud aprobada')
                            ->success()
                            ->send();
                    }),

                Action::make('rechazar')
                    ->label('Rechazar')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn (Loan $record): bool => $record->status === 'pendiente')
                    ->requiresConfirmation()
                    ->form([
                        Textarea::make('notas')
                            ->label('Motivo del rechazo')
                            ->required()
                            ->rows(3),
                    ])
                    ->action(function (Loan $record, array $data) {
                        $record->update([
                            'status' => 'rechazado',
                            'notas' => $data['notas'],
                        ]);

                        Notification::make()
                            ->title('Solicitud rechazada')
                            ->danger()
                            ->send();
                    }),

                EditAction::make()
                    ->visible(fn (Loan $record): bool => in_array($record->status, ['aprobado', 'activo'])),
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
