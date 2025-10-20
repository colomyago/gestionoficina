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
        // Admin y mantenimiento pueden ver todas las solicitudes
        // Trabajadores solo ven las suyas
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, MaintenanceRequest $maintenanceRequest): bool
    {
        // Admin puede ver todas
        // Mantenimiento puede ver todas
        // Trabajador puede ver las que creó
        return $user->isAdmin() 
            || $user->isMantenimiento() 
            || $maintenanceRequest->requested_by === $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Trabajadores y admin pueden crear solicitudes de mantenimiento
        return $user->isTrabajador() || $user->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, MaintenanceRequest $maintenanceRequest): bool
    {
        // Admin puede editar cualquier solicitud
        // Mantenimiento puede editar las que están asignadas a ellos
        return $user->isAdmin() 
            || ($user->isMantenimiento() && $maintenanceRequest->assigned_to === $user->id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, MaintenanceRequest $maintenanceRequest): bool
    {
        // Solo admin puede eliminar solicitudes
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can accept/assign a maintenance request.
     */
    public function accept(User $user): bool
    {
        // Solo personal de mantenimiento puede aceptar solicitudes
        return $user->isMantenimiento() || $user->isAdmin();
    }

    /**
     * Determine whether the user can complete a maintenance request.
     */
    public function complete(User $user, MaintenanceRequest $maintenanceRequest): bool
    {
        // Admin puede completar cualquier solicitud
        // Mantenimiento puede completar las asignadas a ellos
        return $user->isAdmin() 
            || ($user->isMantenimiento() && $maintenanceRequest->assigned_to === $user->id);
    }

    /**
     * Determine whether the user can decommission equipment.
     */
    public function decommission(User $user): bool
    {
        // Solo personal de mantenimiento puede dar de baja equipos
        return $user->isMantenimiento() || $user->isAdmin();
    }
}
