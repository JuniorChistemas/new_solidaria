<?php

namespace App\Policies;

use App\Models\Movement;
use App\Models\User;

class MovementPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('ver movimientos');  
    }

    public function view(User $user, Movement $movement): bool
    {
        return $user->can('ver movimientos');  
    }

    public function create(User $user): bool
    {
        return $user->can('crear movimientos');  
    }

    public function update(User $user, Movement $movement): bool
    {
        return $user->can('editar movimientos');  
    }

    public function delete(User $user, Movement $movement): bool
    {
        return $user->can('eliminar movimientos');  
    }

    public function restore(User $user, Movement $movement): bool
    {
        return true;
    }

    public function forceDelete(User $user, Movement $movement): bool
    {
        return false;
    }
}
