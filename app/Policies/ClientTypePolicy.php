<?php

namespace App\Policies;

use App\Models\ClientType;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ClientTypePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('ver tipos_clientes');  
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ClientType $clientType): bool
    {
        return $user->can('ver tipos_clientes');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('crear tipos_clientes');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ClientType $clientType): bool
    {
        return $user->can('editar tipos_clientes');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ClientType $clientType): bool
    {
        return $user->can('eliminar tipos_clientes');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ClientType $clientType): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ClientType $clientType): bool
    {
        return true;
    }
}
