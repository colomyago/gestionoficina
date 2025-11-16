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
use Filament\Actions\ActionGroup;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use BackedEnum;
use Filament\Support\Icons\Heroicon;
use App\Models\SystemSetting;
use App\Services\LoanValidationService;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GestionSolicitudesResource extends Resource
{
    protected static ?string $model = Loan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?string $navigationLabel = null;

    protected static ?string $modelLabel = 'Solicitud';



    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
    {
        $user = Auth::user();
        
        // Admin ve todas las solicitudes pendientes
        if ($user && $user->isAdmin()) {
            $count = Loan::pending()->count();
            return $count > 0 ? (string) $count : null;
        }
        
        return null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

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
                    ->label(__('Applicant')) //Solicitante
                    ->content(fn ($record) => $record->user->name ?? 'N/A'),

                Placeholder::make('equipment.name')
                    ->label(__('Applicant')) //Equipo   
                    ->content(fn ($record) => $record->equipment->name ?? 'N/A'),

                Placeholder::make('motivo')
                    ->label(__('Reason')) //Motivo
                    ->content(fn ($record) => $record->motivo ?? 'N/A'),

                Placeholder::make('fecha_solicitud')
                    ->label(__('Request Date')) //Fecha de Solicitud
                    ->content(fn ($record) => $record->fecha_solicitud?->format('d/m/Y') ?? 'N/A'),

                Placeholder::make('fecha_prestamo')
                    ->label(__('Loan Date')) //Fecha y hora de Préstamo
                    ->content(fn ($record) => $record->fecha_prestamo?->format('d/m/Y H:i') ?? 'No aprobado aún')
                    ->helperText('Fecha automática de cuando se aprobó'),

                Select::make('status')
                    ->label(__('Status')) //Estado
                    ->options([
                        'pendiente' => 'Pendiente',
                        'rechazado' => 'Rechazado',
                        'activo' => 'Activo',
                        'devuelto' => 'Devuelto',
                    ])
                    ->required(),

                DatePicker::make('fecha_devolucion')
                    ->label(__('Return Date')) //Fecha de devolución estimada
                    ->required(fn ($get) => $get('status') === 'activo')
                    ->helperText('Fecha en que debe devolver el equipo'),

                Textarea::make('notas')
                    ->label(__('Administrator notes')) //Notas del administrador
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
                    ->label(__('Applicant')) //Solicitante
                    ->searchable()
                    ->sortable(),

                TextColumn::make('equipment.name')
                    ->label(__('Device')) //Equipo
                    ->searchable()
                    ->sortable(),

                TextColumn::make('equipment.codigo')
                    ->label(__('Code')) //Còdigo
                    ->searchable(),

                BadgeColumn::make('status')
                    ->label(__('Status')) //Estado
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
                    ->label(__('Request Date')) //Fecha de Solicitud
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('fecha_prestamo')
                    ->label(__('D. Loan')) //F. Préstamo'
                    ->dateTime('d/m/Y H:i')
                    ->placeholder('N/A')
                    ->tooltip('Fecha y hora de aprobación'),

                TextColumn::make('fecha_devolucion')
                    ->label(__('Estimated Dev. Date')) //'F. Dev. Estimada
                    ->date('d/m/Y')
                    ->placeholder('N/A'),

                TextColumn::make('fecha_devolucion_real')
                    ->label(__('Real Dev. Date')) //F. Dev. Real
                    ->date('d/m/Y')
                    ->placeholder('-')
                    ->color(fn ($record) => $record->fecha_devolucion_real ? 'success' : 'gray'),

                TextColumn::make('motivo')
                    ->label(__('Reason'))// Motivo
                    ->limit(30)
                    ->wrap(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('Status'))// Estado
                    ->options([
                        'pendiente' => 'Pendiente',
                        'rechazado' => 'Rechazado',
                        'activo' => 'Activo',
                        'devuelto' => 'Devuelto',
                    ])
                    ->default('pendiente'),
            ])
            ->recordActions([

            ActionGroup::make([
                    Action::make('aprobar')
                        ->label(__('Approve'))// Aprobar
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->visible(fn (Loan $record): bool => $record->status === 'pendiente')
                        ->requiresConfirmation()
                        ->fillForm(fn (Loan $record): array => [
                            'motivo_original' => $record->motivo,
                        ])
                        ->form([
                            Placeholder::make('motivo_original')
                                ->label(__('Solicitation reason')) //Motivo de la Solicitud
                                ->content(fn (Loan $record): string => $record->motivo ?? 'Sin motivo')
                                ->columnSpanFull(),
                            
                            Placeholder::make('info_fecha_prestamo')
                                ->label(__('Date and time of loan')) //Fecha y Hora de Préstamo
                                ->content('Se registrará automáticamente al aprobar')
                                ->helperText('El sistema registrará la fecha y hora exacta de aprobación'),
                            
                            Select::make('periodo_prestamo')
                                ->label('Período de Préstamo')
                                ->options([
                                    '2' => '2 días',
                                    '5' => '5 días (1 semana laboral)',
                                    '10' => '10 días',
                                    '15' => '15 días (2 semanas)',
                                    '21' => '3 semanas',
                                    '30' => '30 días (1 mes)',
                                    '45' => '45 días',
                                    '90' => '90 días (3 meses)',
                                    'custom' => 'Fecha personalizada...',
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
                                ->label('Fecha Exacta')
                                ->minDate(now()->addDay())
                                ->required()
                                ->visible(fn ($get) => $get('periodo_prestamo') === 'custom')
                                ->helperText('Selecciona una fecha específica')
                                ->default(now()->addWeek())
                                ->native(false)
                                ->displayFormat('d/m/Y')
                                ->format('Y-m-d'),
                            
                            Textarea::make('notas')
                                ->label(__('Admin notes')) //Notas del admin
                                ->rows(2)
                                ->placeholder('Condiciones especiales, observaciones, etc.')
                                ->columnSpanFull(),
                        ])
                        ->action(function (Loan $record, array $data) {
                            // Usar transacción para evitar race conditions
                            DB::beginTransaction();
                            
                            try {
                                // Recargar el registro con bloqueo
                                $record = Loan::lockForUpdate()->findOrFail($record->id);
                                $record->load('equipment', 'user');
                                
                                // Calcular fecha de devolución basada en el período o fecha custom
                                if (isset($data['periodo_prestamo']) && $data['periodo_prestamo'] !== 'custom' && is_numeric($data['periodo_prestamo'])) {
                                    $data['fecha_devolucion'] = now()->addDays((int)$data['periodo_prestamo'])->format('Y-m-d');
                                }
                                
                                // Validar fecha de devolución
                                $dateValidation = LoanValidationService::validateReturnDate($data['fecha_devolucion'] ?? null);
                                if (!$dateValidation['valid']) {
                                    DB::rollBack();
                                    Notification::make()
                                        ->title('Fecha inválida')
                                        ->danger()
                                        ->body($dateValidation['message'])
                                        ->send();
                                    return;
                                }
                                
                                // Validar que el préstamo sea posible (ahora acepta IDs u objetos)
                                $validation = LoanValidationService::canLoanEquipment(
                                    $record->user,
                                    $record->equipment,
                                    $record->id
                                );
                                
                                if (!$validation['valid']) {
                                    DB::rollBack();
                                    Notification::make()
                                        ->title('No se puede aprobar')
                                        ->danger()
                                        ->body($validation['message'])
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

                                // Actualizar el equipo
                                $record->equipment->update([
                                    'status' => 'prestado',
                                    'user_id' => $record->user_id,
                                ]);

                                DB::commit();
                                
                                Notification::make()
                                    ->title('Solicitud aprobada')
                                    ->success()
                                    ->body('El equipo ha sido asignado a ' . $record->user->name . ' el ' . $fechaPrestamoAhora->format('d/m/Y H:i'))
                                    ->send();
                                    
                            } catch (\Exception $e) {
                                DB::rollBack();
                                Notification::make()
                                    ->title('Error al aprobar')
                                    ->danger()
                                    ->body('Ocurrió un error: ' . $e->getMessage())
                                    ->send();
                            }
                        }),

                    Action::make('rechazar')
                        ->label(__('Reject')) //Rechazar
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->visible(fn (Loan $record): bool => $record->status === 'pendiente')
                        ->requiresConfirmation()
                        ->modalDescription(fn (Loan $record): string => 
                            'Vas a rechazar la solicitud de ' . $record->user->name . 
                            ' para el equipo ' . $record->equipment->name)
                        ->form([
                            Placeholder::make('motivo_original')
                                ->label(__('Solicitation reason')) //Motivo de la Solicitud
                                ->content(fn (Loan $record): string => $record->motivo ?? 'Sin motivo')
                                ->columnSpanFull(),
                            
                            Textarea::make('notas')
                                ->label(__('Reason')) //Motivo del Rechazo
                                ->required()
                                ->rows(3)
                                ->placeholder('Explica por qué se rechaza esta solicitud')
                                ->columnSpanFull(),
                        ])
                        ->action(function (Loan $record, array $data) {
                            DB::beginTransaction();
                            try {
                                // Recargar con bloqueo para evitar race conditions
                                $record = Loan::lockForUpdate()->findOrFail($record->id);
                                
                                // Verificar que aún esté pendiente
                                if ($record->status !== 'pendiente') {
                                    DB::rollBack();
                                    Notification::make()
                                        ->title(__('Error'))
                                        ->danger()
                                        ->body(__('This request is no longer pending.'))
                                        ->send();
                                    return;
                                }
                                
                                $record->update([
                                    'status' => 'rechazado',
                                    'notas' => $data['notas'],
                                ]);

                                DB::commit();

                                Notification::make()
                                    ->title('Solicitud rechazada')
                                    ->danger()
                                    ->body('Se ha notificado al usuario sobre el rechazo.')
                                    ->send();
                            } catch (\Exception $e) {
                                DB::rollBack();
                                Notification::make()
                                    ->title(__('Error'))
                                    ->danger()
                                    ->body(__('An error occurred while rejecting the request. Please try again.'))
                                    ->send();
                            }
                        }),

                    EditAction::make()
                        ->visible(fn (Loan $record): bool => $record->status === 'activo'),
                    ]),
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
        return __('Loan management');  
    }


    public static function getPluralLabel(): string
    {
        return __('Loan management')    ;
    }

    public static function getNavigationLabel(): string
    {
        return __('Loan management');
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
