<?php

namespace App\Filament\Resources\SolicitudPrestamoResource\Pages;

use App\Filament\Resources\SolicitudPrestamoResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateSolicitudPrestamo extends CreateRecord
{
    protected static string $resource = SolicitudPrestamoResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Si no viene user_id (trabajador), usar el usuario actual
        if (!isset($data['user_id']) || !Auth::user()->isAdmin()) {
            $data['user_id'] = Auth::id();
        }
        
        $data['status'] = 'pendiente';
        $data['fecha_solicitud'] = now();
        
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
