<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SolicitudPrestamoResource\Pages;
use App\Models\Loan;
use App\Models\Equipment;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Actions\ViewAction;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use BackedEnum;
use Filament\Support\Icons\Heroicon;

class SolicitudPrestamoResource extends Resource
{
    protected static ?string $model = Loan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentCheck;

    protected static ?string $navigationLabel = 'Mis Solicitudes';

    protected static ?string $modelLabel = 'Solicitud de Préstamo';

    protected static ?string $pluralModelLabel = 'Mis Solicitudes';

    protected static ?int $navigationSort = 1;

    // Visible para trabajadores y admin
    public static function canViewAny(): bool
    {
        $user = Auth::user();
        return $user && in_array($user->role, ['trabajador', 'admin']);
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('Usuario')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->required()
                    ->visible(fn () => Auth::user()->role === 'admin')
                    ->helperText('Selecciona el usuario que solicita el equipo'),

                Select::make('equipment_id')
                    ->label('Equipo')
                    ->options(function () {
                        return Equipment::where('status', 'disponible')
                            ->get()
                            ->mapWithKeys(function ($equipment) {
                                return [$equipment->id => $equipment->name . ' (' . $equipment->codigo . ')'];
                            });
                    })
                    ->searchable()
                    ->required()
                    ->helperText('Solo se muestran equipos disponibles'),

                Textarea::make('motivo')
                    ->label('Motivo de la solicitud')
                    ->required()
                    ->rows(3)
                    ->maxLength(500)
                    ->helperText('Explica brevemente por qué necesitas este equipo'),

                DatePicker::make('fecha_devolucion')
                    ->label('Fecha estimada de devolución')
                    ->required()
                    ->minDate(now()->addDay())
                    ->helperText('¿Cuándo planeas devolver el equipo?'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                // Admin ve todas las solicitudes, trabajadores solo las suyas
                if (Auth::user()->role !== 'admin') {
                    return $query->where('user_id', Auth::id());
                }
                return $query;
            })
            ->columns([
                TextColumn::make('user.name')
                    ->label('Solicitante')
                    ->searchable()
                    ->sortable()
                    ->visible(fn () => Auth::user()->role === 'admin'),

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
                    ->label('Fecha Solicitud')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('fecha_prestamo')
                    ->label('Fecha Préstamo')
                    ->date('d/m/Y')
                    ->placeholder('N/A'),

                TextColumn::make('fecha_devolucion')
                    ->label('Devolución Estimada')
                    ->date('d/m/Y'),

                TextColumn::make('motivo')
                    ->label('Motivo')
                    ->limit(50)
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
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
                Action::make('devolver')
                    ->label('Devolver')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->color('success')
                    ->visible(fn (Loan $record): bool => $record->status === 'activo')
                    ->requiresConfirmation()
                    ->action(function (Loan $record) {
                        $record->update(['status' => 'devuelto']);
                        $record->equipment->update([
                            'status' => 'disponible',
                            'user_id' => null,
                            'fecha_prestado' => null,
                            'fecha_devolucion' => null,
                        ]);
                        
                        Notification::make()
                            ->title('Equipo devuelto exitosamente')
                            ->success()
                            ->send();
                    }),
                
                DeleteAction::make()
                    ->visible(fn (Loan $record): bool => $record->status === 'pendiente'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
            'index' => Pages\ListSolicitudPrestamos::route('/'),
            'create' => Pages\CreateSolicitudPrestamo::route('/create'),
            'view' => Pages\ViewSolicitudPrestamo::route('/{record}'),
        ];
    }

    // Hook antes de crear la solicitud
    public static function beforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();
        $data['status'] = 'pendiente';
        $data['fecha_solicitud'] = now();
        
        return $data;
    }
}
