<?php

namespace App\Policies;

use App\Models\MaintenanceRequest;
use App\Models\User;

class MaintenanceRequestPolicy
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
    public function view(User $user, MaintenanceRequest $maintenanceRequest): bool
    {
        return $user->isAdmin() 
            || $user->isMantenimiento() 
            || $maintenanceRequest->requested_by === $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isTrabajador() || $user->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, MaintenanceRequest $maintenanceRequest): bool
    {
        return $user->isAdmin() 
            || ($user->isMantenimiento() && $maintenanceRequest->assigned_to === $user->id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, MaintenanceRequest $maintenanceRequest): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can accept/assign a maintenance request.
     */
    public function accept(User $user): bool
    {
        return $user->isMantenimiento() || $user->isAdmin();
    }

    /**
     * Determine whether the user can complete a maintenance request.
     */
    public function complete(User $user, MaintenanceRequest $maintenanceRequest): bool
    {
        return $user->isAdmin() 
            || ($user->isMantenimiento() && $maintenanceRequest->assigned_to === $user->id);
    }

    /**
     * Determine whether the user can decommission equipment.
     */
    public function decommission(User $user): bool
    {
        return $user->isMantenimiento() || $user->isAdmin();
    }
}
