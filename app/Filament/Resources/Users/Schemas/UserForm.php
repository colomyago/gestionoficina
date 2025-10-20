<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(255),
                    
                TextInput::make('email')
                    ->label('Correo Electrónico')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                    
                Select::make('role_id')
                    ->label('Rol')
                    ->relationship('role', 'name')
                    ->required(),

                DateTimePicker::make('email_verified_at')
                    ->label('Email Verificado')
                    ->nullable(),
                    
                TextInput::make('password')
                    ->label('Contraseña')
                    ->password()
                    ->required(fn (string $context): bool => $context === 'create')
                    ->dehydrated(fn ($state) => filled($state))
                    ->minLength(8)
                    ->maxLength(255)
                    ->helperText('Mínimo 8 caracteres. Dejar en blanco para no cambiar.'),
            ]);
    }
}

