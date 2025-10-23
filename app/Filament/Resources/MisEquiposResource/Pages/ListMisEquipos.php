<?php

namespace App\Filament\Resources\MisEquiposResource\Pages;

use App\Filament\Resources\MisEquiposResource;
use App\Filament\Widgets\MisEquiposStatsWidget;
use Filament\Resources\Pages\ListRecords;

class ListMisEquipos extends ListRecords
{
    protected static string $resource = MisEquiposResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // No hay acciones en el header para trabajadores
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            MisEquiposStatsWidget::class,
        ];
    }
}
