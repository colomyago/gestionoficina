<?php

namespace App\Policies;

use App\Models\Loan;
use App\Models\User;

class LoanPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Todos pueden ver préstamos
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Loan $loan): bool
    {
        // Admin puede ver todos
        // Usuario puede ver sus propios préstamos
        return $user->isAdmin() || $loan->user_id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Admin puede crear préstamos (asignar equipos)
        // Trabajadores pueden solicitar préstamos
        return $user->isAdmin() || $user->isTrabajador();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Loan $loan): bool
    {
        // Solo admin puede modificar préstamos
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Loan $loan): bool
    {
        // Solo admin puede eliminar préstamos
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can return equipment.
     */
    public function return(User $user, Loan $loan): bool
    {
        // Admin puede devolver cualquier equipo
        // Usuario puede devolver sus propios equipos
        return $user->isAdmin() || $loan->user_id === $user->id;
    }
}
