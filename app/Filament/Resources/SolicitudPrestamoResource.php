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
        return $user && ($user->isTrabajador() || $user->isAdmin());
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label(__('User'))
                    ->relationship('user', 'name')
                    ->searchable()
                    ->required()
                    ->visible(fn () => Auth::user()->isAdmin())
                    ->helperText(__('Select the user requesting the device')),

                Select::make('equipment_id')
                    ->label(__('Device'))
                    ->options(function () {
                        return Equipment::where('status', 'disponible')
                            ->get()
                            ->mapWithKeys(function ($equipment) {
                                return [$equipment->id => $equipment->name . ' (' . $equipment->codigo . ')'];
                            });
                    })
                    ->searchable()
                    ->required()
                    ->helperText(__('Only available devices are shown')),

                Textarea::make('motivo')
                    ->label(__('Request reason'))
                    ->required()
                    ->rows(3)
                    ->maxLength(500)
                    ->helperText(__('Briefly explain why you need this device')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                // Admin ve todas las solicitudes, trabajadores solo las suyas
                if (!Auth::user()->isAdmin()) {
                    return $query->where('user_id', Auth::id());
                }
                return $query;
            })
            ->columns([
                TextColumn::make('user.name')
                    ->label(__('Applicant'))
                    ->searchable()
                    ->sortable()
                    ->visible(fn () => Auth::user()->isAdmin()),

                TextColumn::make('equipment.name')
                    ->label(__('Device'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('equipment.codigo')
                    ->label(__('Code'))
                    ->searchable(),

                BadgeColumn::make('status')
                    ->label(__('Status'))
                    ->colors([
                        'warning' => 'pendiente',
                        'danger' => 'rechazado',
                        'primary' => 'activo',
                        'secondary' => 'devuelto',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pendiente' => __('Pending'),
                        'rechazado' => __('Rejected'),
                        'activo' => __('Active'),
                        'devuelto' => __('Returned'),
                        default => $state,
                    }),

                TextColumn::make('fecha_solicitud')
                    ->label(__('Request Date'))
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('fecha_prestamo')
                    ->label(__('Loan Date'))
                    ->dateTime('d/m/Y H:i')
                    ->placeholder('N/A')
                    ->tooltip(__('Approval date and time')),

                TextColumn::make('fecha_devolucion')
                    ->label(__('Estimated Return'))
                    ->date('d/m/Y'),

                TextColumn::make('fecha_devolucion_real')
                    ->label(__('Actual Return'))
                    ->date('d/m/Y')
                    ->placeholder(__('Pending'))
                    ->tooltip(__('Date the device was actually returned')),

                TextColumn::make('motivo')
                    ->label(__('Reason'))
                    ->limit(50)
                    ->wrap(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('Status'))
                    ->options([
                        'pendiente' => __('Pending'),
                        'rechazado' => __('Rejected'),
                        'activo' => __('Active'),
                        'devuelto' => __('Returned'),
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
                Action::make('devolver')
                    ->label(__('Return'))
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->color('success')
                    ->visible(fn (Loan $record): bool => $record->status === 'activo')
                    ->requiresConfirmation()
                    ->action(function (Loan $record) {
                        $record->update([
                            'status' => 'devuelto',
                            'fecha_devolucion_real' => now(),
                        ]);
                        
                        $record->equipment->update([
                            'status' => 'disponible',
                            'user_id' => null,
                        ]);
                        
                        Notification::make()
                            ->title(__('Device returned successfully'))
                            ->success()
                            ->body(__('The device has been marked as available.'))
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


    public static function getLabel(): string
    {
        return __('My requests');  
    }


    public static function getPluralLabel(): string
    {
        return __('My requests');
    }

    public static function getNavigationLabel(): string
    {
        return __('My requests');
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