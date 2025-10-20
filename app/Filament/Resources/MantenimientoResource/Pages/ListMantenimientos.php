<?php

namespace App\Filament\Resources\MantenimientoResource\Pages;

use App\Filament\Resources\MantenimientoResource;
use Filament\Resources\Pages\ListRecords;

class ListMantenimientos extends ListRecords
{
    protected static string $resource = MantenimientoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
