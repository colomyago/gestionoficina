<?php

namespace App\Filament\Resources\GestionSolicitudesResource\Pages;

use App\Filament\Resources\GestionSolicitudesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGestionSolicitud extends EditRecord
{
    protected static string $resource = GestionSolicitudesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
