<?php

namespace App\Filament\Resources\Roles\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class RoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->label(__('Code'))
                    ->translateLabel()
                    ->required(),
                TextInput::make('name')
                    ->label(__('Description'))
                    ->translateLabel()
                    ->required(),
            ]);
    }
}
