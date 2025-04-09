<?php

namespace App\Policies;

use App\Models\Local;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LocalPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('ver locales');     
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Local $local): bool
    {
        return $user->can('ver locales');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('crear locales');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Local $local): bool
    {
        return $user->can('editar locales');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Local $local): bool
    {
        return $user->can('eliminar locales');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Local $local): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Local $local): bool
    {
        return false;
    }
}
