<?php

namespace App\Filament\Resources\MisEquiposResource\Pages;

use App\Filament\Resources\MisEquiposResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Schema;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;

class ViewMisEquipo extends ViewRecord
{
    protected static string $resource = MisEquiposResource::class;

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información del Equipo')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Nombre'),
                        TextEntry::make('codigo')
                            ->label('Código'),
                        TextEntry::make('categoria')
                            ->label('Categoría'),
                        TextEntry::make('description')
                            ->label('Descripción')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Información del Préstamo')
                    ->schema([
                        TextEntry::make('fecha_prestado')
                            ->label('Fecha de Préstamo')
                            ->date('d/m/Y'),
                        TextEntry::make('fecha_devolucion')
                            ->label('Fecha de Devolución Estimada')
                            ->date('d/m/Y')
                            ->badge()
                            ->color(fn ($record) => 
                                $record->fecha_devolucion && $record->fecha_devolucion->isPast() 
                                    ? 'danger' 
                                    : 'success'
                            ),
                    ])
                    ->columns(2),
            ]);
    }
}
