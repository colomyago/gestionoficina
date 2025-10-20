<?php

namespace App\Filament\Resources\GestionSolicitudesResource\Pages;

use App\Filament\Resources\GestionSolicitudesResource;
use Filament\Resources\Pages\ListRecords;

class ListGestionSolicitudes extends ListRecords
{
    protected static string $resource = GestionSolicitudesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
