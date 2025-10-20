<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Solo admin puede ver todos los usuarios en el panel Filament
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        // Admin puede ver cualquier usuario
        // Los usuarios pueden ver su propio perfil
        // Trabajadores pueden ver otros usuarios
        return $user->isAdmin() || $user->id === $model->id || $user->isTrabajador();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Solo admin puede crear usuarios
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        // Admin puede editar cualquier usuario
        // Los usuarios pueden editar su propio perfil (datos básicos)
        return $user->isAdmin() || $user->id === $model->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        // Solo admin puede eliminar usuarios
        // No se puede eliminar a sí mismo
        return $user->isAdmin() && $user->id !== $model->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return $user->isAdmin() && $user->id !== $model->id;
    }

    /**
     * Determine whether the user can change roles.
     */
    public function changeRole(User $user): bool
    {
        // Solo admin puede cambiar roles
        return $user->isAdmin();
    }
}
