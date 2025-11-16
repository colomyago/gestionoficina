<?php

namespace App\Filament\Resources\SolicitudPrestamoResource\Pages;

use App\Filament\Resources\SolicitudPrestamoResource;
use App\Models\Equipment;
use App\Models\Loan;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class CreateSolicitudPrestamo extends CreateRecord
{
    protected static string $resource = SolicitudPrestamoResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Validar que el equipo esté disponible
        $equipment = Equipment::find($data['equipment_id']);
        
        if (!$equipment || $equipment->status !== 'disponible') {
            Notification::make()
                ->title('Equipo no disponible')
                ->danger()
                ->body('El equipo seleccionado no está disponible.')
                ->send();
            $this->halt();
        }

        // Si no viene user_id (trabajador), usar el usuario actual
        if (!isset($data['user_id']) || !Auth::user()->isAdmin()) {
            $data['user_id'] = Auth::id();
        }
        
        // Validar que no exista solicitud duplicada para el usuario final
        $userId = $data['user_id'];
        $existingLoan = Loan::where('equipment_id', $data['equipment_id'])
            ->where('user_id', $userId)
            ->whereIn('status', ['pendiente', 'activo'])
            ->first();

        if ($existingLoan) {
            $statusText = $existingLoan->status === 'pendiente' ? 'pendiente' : 'activa';
            Notification::make()
                ->title('Solicitud duplicada')
                ->danger()
                ->body("Ya existe una solicitud {$statusText} para este equipo.")
                ->send();
            $this->halt();
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
