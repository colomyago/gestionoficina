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
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Equipment $equipment): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Equipment $equipment): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Equipment $equipment): bool
    {
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
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can send equipment to maintenance.
     */
    public function sendToMaintenance(User $user): bool
    {
        return $user->isTrabajador() || $user->isAdmin();
    }

    /**
     * Determine whether the user can manage maintenance (mark as repaired or decommission).
     */
    public function manageMaintenance(User $user): bool
    {
        return $user->isMantenimiento() || $user->isAdmin();
    }
}
