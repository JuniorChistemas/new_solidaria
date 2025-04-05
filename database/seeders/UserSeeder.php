<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //get the roles
        $adminRole = Role::findById(1);
        $vendedorRole = Role::findById(2);
        $almacenRole = Role::findById(3);
        $auditorRole = Role::findById(4);
        // get the permissions for the admin role
        $permissions = Permission::all()->pluck('name')->toArray();
        // create the admin user
        $admin_1 = User::create([
            'name' => 'Jesus Junior',
            'email' => 'junior@gmail.com',
            'username' => 'junior15',
            'password' => Hash::make('12345678'),
            'status' => 1,
        ]);
        $admin_2 = User::create([
            'name' => 'Karin Hair',
            'email' => 'kayisanta5@gmail.com',
            'username' => 'kchozo27',
            'password' => Hash::make('27062706'),
            'status' => 1,
        ]);
        $adminRole->syncPermissions($permissions);
        $admin_1->assignRole($adminRole);
        $admin_2->assignRole($adminRole);

        $admin_3= User::create([
            'name' => 'Anthony Marck',
            'email' => 'thonymarck385213xd@gmail.com',
            'username' => 'thonymarck',
            'password' => Hash::make('12345678'),
            'status' => 1,
        ]);
        $adminRole->syncPermissions($permissions);
        $admin_3->assignRole($adminRole);
    }
}
