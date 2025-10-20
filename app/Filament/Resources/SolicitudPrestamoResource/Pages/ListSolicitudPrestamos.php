<?php

namespace App\Filament\Resources\SolicitudPrestamoResource\Pages;

use App\Filament\Resources\SolicitudPrestamoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSolicitudPrestamos extends ListRecords
{
    protected static string $resource = SolicitudPrestamoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Nueva Solicitud')
                ->icon('heroicon-o-plus'),
        ];
    }
}
