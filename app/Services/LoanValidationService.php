<?php

namespace App\Services;

use App\Models\Loan;
use App\Models\Equipment;
use App\Models\SystemSetting;
use Illuminate\Support\Facades\DB;

class LoanValidationService
{
    /**
     * Validar que un equipo pueda ser prestado
     * @param \App\Models\User|int $user Usuario o ID del usuario
     * @param \App\Models\Equipment|int $equipment Equipo o ID del equipo
     * @param int|null $excludeLoanId ID del préstamo a excluir (para ediciones)
     */
    public static function canLoanEquipment($user, $equipment, ?int $excludeLoanId = null): array
    {
        // Normalizar a IDs si se reciben objetos
        $userId = is_object($user) ? $user->id : $user;
        $equipmentId = is_object($equipment) ? $equipment->id : $equipment;
        
        // Obtener el equipo si no es un objeto
        if (!is_object($equipment)) {
            $equipment = Equipment::find($equipmentId);
        }
        
        if (!$equipment) {
            return [
                'valid' => false,
                'message' => 'El equipo no existe'
            ];
        }

        // Verificar disponibilidad del equipo
        if ($equipment->status !== 'disponible') {
            return [
                'valid' => false,
                'message' => "El equipo no está disponible. Estado actual: {$equipment->status}"
            ];
        }

        // Verificar que no haya otro préstamo activo
        $otherActiveLoan = Loan::where('equipment_id', $equipmentId)
            ->where('status', 'activo')
            ->when($excludeLoanId, fn($q) => $q->where('id', '!=', $excludeLoanId))
            ->first();

        if ($otherActiveLoan) {
            return [
                'valid' => false,
                'message' => "El equipo ya está prestado a {$otherActiveLoan->user->name}"
            ];
        }

        // Verificar límite de equipos del usuario
        $maxEquipments = SystemSetting::get('max_equipments_per_worker', 5);
        $currentActiveLoans = Loan::where('user_id', $userId)
            ->where('status', 'activo')
            ->when($excludeLoanId, fn($q) => $q->where('id', '!=', $excludeLoanId))
            ->count();

        if ($currentActiveLoans >= $maxEquipments) {
            return [
                'valid' => false,
                'message' => "El usuario ya tiene {$currentActiveLoans} equipos activos. Límite: {$maxEquipments}"
            ];
        }

        // Verificar solicitudes duplicadas
        $duplicateLoan = Loan::where('equipment_id', $equipmentId)
            ->where('user_id', $userId)
            ->whereIn('status', ['pendiente', 'activo'])
            ->when($excludeLoanId, fn($q) => $q->where('id', '!=', $excludeLoanId))
            ->first();

        if ($duplicateLoan) {
            $statusText = $duplicateLoan->status === 'pendiente' ? 'solicitud pendiente' : 'préstamo activo';
            return [
                'valid' => false,
                'message' => "El usuario ya tiene una {$statusText} para este equipo"
            ];
        }

        return [
            'valid' => true,
            'message' => 'El préstamo es válido'
        ];
    }

    /**
     * Validar fecha de devolución
     * @deprecated Use DateValidationService::validateReturnDate() instead
     */
    public static function validateReturnDate($date): array
    {
        return \App\Services\DateValidationService::validateReturnDate($date);
    }
}
