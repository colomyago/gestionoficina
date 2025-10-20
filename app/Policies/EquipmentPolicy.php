<?php

namespace App\Policies;

use App\Models\Equipment;
use App\Models\User;

class EquipmentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Todos los roles pueden ver la lista de equipos
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Equipment $equipment): bool
    {
        // Todos pueden ver equipos individuales
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Solo admin puede crear equipos
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Equipment $equipment): bool
    {
        // Solo admin puede editar equipos
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Equipment $equipment): bool
    {
        // Solo admin puede eliminar equipos
        // Y no se puede eliminar si está prestado
        return $user->isAdmin() && !$equipment->isLoaned();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Equipment $equipment): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Equipment $equipment): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can assign equipment to users.
     */
    public function assign(User $user): bool
    {
        // Solo admin puede asignar equipos
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can send equipment to maintenance.
     */
    public function sendToMaintenance(User $user): bool
    {
        // Trabajadores y admin pueden enviar a mantenimiento
        return $user->isTrabajador() || $user->isAdmin();
    }

    /**
     * Determine whether the user can manage maintenance (mark as repaired or decommission).
     */
    public function manageMaintenance(User $user): bool
    {
        // Solo personal de mantenimiento puede gestionar reparaciones
        return $user->isMantenimiento() || $user->isAdmin();
    }
}
