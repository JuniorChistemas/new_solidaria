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
               // create permissions

        // model users
        Permission::create(['name' => 'crear usuarios']);
        Permission::create(['name' => 'editar usuarios']);
        Permission::create(['name' => 'eliminar usuarios']);
        Permission::create(['name' => 'ver usuarios']);
    
        // model clients
        Permission::create(['name' => 'crear clientes']);
        Permission::create(['name' => 'editar clientes']);
        Permission::create(['name' => 'eliminar clientes']);
        Permission::create(['name' => 'ver clientes']);

        // model suppliers
        Permission::create(['name' => 'crear proveedores']);
        Permission::create(['name' => 'editar proveedores']);
        Permission::create(['name' => 'eliminar proveedores']);
        Permission::create(['name' => 'ver proveedores']);

        // model categories
        Permission::create(['name' => 'crear categorias']);
        Permission::create(['name' => 'editar categorias']);
        Permission::create(['name' => 'eliminar categorias']);
        Permission::create(['name' => 'ver categorias']);

        // model doctors
        Permission::create(['name' => 'crear doctores']);
        Permission::create(['name' => 'editar doctores']);
        Permission::create(['name' => 'eliminar doctores']);
        Permission::create(['name' => 'ver doctores']);

        // model laboratorios
        Permission::create(['name' => 'crear laboratorios']);
        Permission::create(['name' => 'editar laboratorios']);
        Permission::create(['name' => 'eliminar laboratorios']);
        Permission::create(['name' => 'ver laboratorios']);

        // model tipos_clientes
        Permission::create(['name' => 'crear tipos_clientes']);
        Permission::create(['name' => 'editar tipos_clientes']);
        Permission::create(['name' => 'eliminar tipos_clientes']);
        Permission::create(['name' => 'ver tipos_clientes']);


    }
}
