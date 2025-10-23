<?php

namespace App\Filament\Resources\Equipment\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class EquipmentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('status'),
                TextEntry::make('user.name')
                    ->label('Asignado a')
                    ->placeholder('Sin asignar'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
