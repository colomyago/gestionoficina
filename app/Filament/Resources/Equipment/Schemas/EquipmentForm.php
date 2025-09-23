<?php

namespace App\Filament\Resources\Equipment\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class EquipmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema  
            ->components([
                TextInput::make('name')
                    ->translateLabel()
                    ->required(),
                Textarea::make('description')
                    ->translateLabel()
                    ->columnSpanFull(),
                TextInput::make('status')
                    ->translateLabel()
                    ->required()
                    ->default('disponible'),
                TextInput::make('user_id')
                    ->numeric(),
                DatePicker::make('fecha_prestado'),
                DatePicker::make('fecha_devolucion'),
            ]);
    }
}
