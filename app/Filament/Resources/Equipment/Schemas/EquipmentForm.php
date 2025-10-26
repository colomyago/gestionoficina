<?php

namespace App\Filament\Resources\Equipment\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use App\Models\User;

class EquipmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema  
            ->components([
                TextInput::make('name')
                    ->label(__('Device name'))
                    ->required()
                    ->maxLength(255),
                    
                TextInput::make('codigo')
                    ->label(__('Code'))
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->helperText('Código único del equipo (ej: LAP-001)'),
                    
                Select::make('categoria')
                    ->label(__('Category'))
                    ->options([
                        'Computadoras' => 'Computadoras',
                        'Proyección' => 'Proyección',
                        'Fotografía' => 'Fotografía',
                        'Tablets' => 'Tablets',
                        'Monitores' => 'Monitores',
                        'Impresoras' => 'Impresoras',
                        'Audio' => 'Audio',
                        'Redes' => 'Redes',
                        'Almacenamiento' => 'Almacenamiento',
                        'Periféricos' => 'Periféricos',
                        'Otros' => 'Otros',
                    ])
                    ->searchable()
                    ->nullable(),
                    
                Textarea::make('description')
                    ->label(__('Description'))
                    ->columnSpanFull()
                    ->rows(3),
                    
                Select::make('status')
                    ->label(__('Status'))
                    ->options([
                        'disponible' => 'Disponible',
                        'prestado' => 'Prestado',
                        'mantenimiento' => 'En Mantenimiento',
                        'baja' => 'Dado de Baja',
                    ])
                    ->default('disponible')
                    ->required(),
                    
                Select::make('user_id')
                    ->label(__('Assigned to'))
                    ->relationship('user', 'name')
                    ->searchable()
                    ->nullable()
                    ->helperText('Usuario que actualmente tiene el equipo'),
            ]);
    }
}

