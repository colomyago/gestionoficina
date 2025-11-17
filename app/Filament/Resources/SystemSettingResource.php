<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SystemSettingResource\Pages;
use App\Models\SystemSetting;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Illuminate\Support\Facades\Auth;
use BackedEnum;
use Filament\Support\Icons\Heroicon;

class SystemSettingResource extends Resource
{
    protected static ?string $model = SystemSetting::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static ?string $navigationLabel = null;

    protected static ?int $navigationSort = 10;

    public static function getNavigationGroup(): ?string
    {
        return __('Administration');
    }

    // Solo visible para admin
    public static function canViewAny(): bool
    {
        $user = Auth::user();
        return $user && $user->isAdmin();
    }

    public static function canCreate(): bool
    {
        return false; // No permitir crear manualmente
    }

    public static function canDelete($record): bool
    {
        return false; // No permitir eliminar configuraciones del sistema
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('key')
                    ->label(__('Setting'))
                    ->disabled()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'max_equipments_per_worker' => 'Límite de Equipos por Trabajador',
                        'dias_aviso_vencimiento' => 'Días de Advertencia Antes de Vencimiento',
                        'days_before_overdue_warning' => 'Días de Advertencia Antes de Vencimiento',
                        default => $state,
                    })
                    ->columnSpanFull(),

                Textarea::make('description')
                    ->label(__('Description'))
                    ->disabled()
                    ->rows(2)
                    ->columnSpanFull()
                    ->hiddenLabel(),

                TextInput::make('value')
                    ->label(fn ($record) => match ($record?->key) {
                        'max_equipments_per_worker' => 'Cantidad Máxima',
                        'dias_aviso_vencimiento' => 'Cantidad de Días',
                        'days_before_overdue_warning' => 'Cantidad de Días',
                        default => 'Valor',
                    })
                    ->numeric(fn ($record) => $record && $record->type === 'integer')
                    ->minValue(fn ($record) => $record && $record->type === 'integer' ? 1 : null)
                    ->maxValue(fn ($record) => $record && $record->key === 'max_equipments_per_worker' ? 50 : null)
                    ->step(1)
                    ->required()
                    ->helperText(fn ($record) => match ($record?->key) {
                        'max_equipments_per_worker' => 'Cantidad máxima de equipos que un trabajador puede tener prestados al mismo tiempo (entre 1 y 50)',
                        'dias_aviso_vencimiento' => 'Días antes de la fecha de devolución para mostrar advertencias visuales (recomendado: 3-14 días)',
                        'days_before_overdue_warning' => 'Días antes de la fecha de devolución para mostrar advertencias visuales (recomendado: 3-14 días)',
                        default => 'Ingresa el nuevo valor para esta configuración',
                    })
                    ->suffix(fn ($record) => match ($record?->key) {
                        'max_equipments_per_worker' => 'equipos',
                        'dias_aviso_vencimiento' => 'días',
                        'days_before_overdue_warning' => 'días',
                        default => null,
                    })
                    ->placeholder(fn ($record) => $record?->value ?? '5'),

                Select::make('type')
                    ->label(__('Type'))
                    ->options([
                        'string' => 'Texto',
                        'integer' => 'Número entero',
                        'boolean' => 'Verdadero/Falso',
                        'json' => 'JSON',
                    ])
                    ->disabled()
                    ->dehydrated(false)
                    ->hidden(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key')
                    ->label(__('Key'))
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->copyable()
                    ->formatStateUsing(fn (?string $state): string => $state ? __($state) : ''),

                TextColumn::make('value')
                    ->label(__('Value'))
                    ->searchable()
                    ->badge()
                    ->color('success'),

                TextColumn::make('type')
                    ->label(__('Type'))
                    ->badge()
                    ->color('gray')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'integer' => 'Número',
                        'boolean' => 'Booleano',
                        'json' => 'JSON',
                        default => 'Texto',
                    }),

                TextColumn::make('description')
                    ->label(__('Description'))
                    ->limit(50)
                    ->wrap()
                    ->searchable(),

                TextColumn::make('updated_at')
                    ->label(__('Last Update'))
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->defaultSort('key', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSystemSettings::route('/'),
            'create' => Pages\CreateSystemSetting::route('/create'),
            'edit' => Pages\EditSystemSetting::route('/{record}/edit'),
        ];
    }

    public static function getLabel(): string
    {
        return __('System Setting');
    }

    public static function getPluralLabel(): string
    {
        return __('System Settings');
    }

    public static function getNavigationLabel(): string
    {
        return __('System Settings');
    }
}
