<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $administrador = Role::create(['name' => 'administrador']);
        $vendedor = Role::create(['name' => 'vendedor']);
        $almacen = Role::create(['name' => 'almacen']);
        $auditor = Role::create(['name' => 'auditor']);

        // Asignar permisos a roles
        $administrador->syncPermissions(Permission::all());

        $vendedor->syncPermissions([
            'crear clientes', 'editar clientes', 'eliminar clientes', 'ver clientes',
        ]);

        $almacen->syncPermissions([
            'crear categorias', 'editar categorias', 'eliminar categorias', 'ver categorias',
            'crear proveedores', 'editar proveedores', 'eliminar proveedores', 'ver proveedores',
        ]);

        $auditor->syncPermissions([
            'ver usuarios', 'ver clientes', 'ver proveedores', 'ver categorias', 'ver doctores', 'ver laboratorios',
        ]);
    }
}
