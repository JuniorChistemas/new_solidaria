<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // model users
            'crear usuarios', 'editar usuarios', 'eliminar usuarios', 'ver usuarios',
            // model clients
            'crear clientes', 'editar clientes', 'eliminar clientes', 'ver clientes',
            // model suppliers
            'crear proveedores', 'editar proveedores', 'eliminar proveedores', 'ver proveedores',
            // model categories
            'crear categorias', 'editar categorias', 'eliminar categorias', 'ver categorias',
            // model doctors
            'crear doctores', 'editar doctores', 'eliminar doctores', 'ver doctores',
            // model laboratorios
            'crear laboratorios', 'editar laboratorios', 'eliminar laboratorios', 'ver laboratorios',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
