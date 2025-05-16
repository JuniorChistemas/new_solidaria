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
        // Search roles by name
        $adminRole = Role::where('name', 'administrador')->first();
        $vendedorRole = Role::where('name', 'vendedor')->first();
        $almacenRole = Role::where('name', 'almacen')->first();
        $auditorRole = Role::where('name', 'auditor')->first();

        // Create users and assign roles
        $admin_1 = User::create([
            'name' => 'Jesus Junior',
            'email' => 'junior@gmail.com',
            'username' => 'junior15',
            'local_id' => 1,
            'password' => Hash::make('12345678'),
            'status' => 1,
        ]);
        $admin_1->assignRole($adminRole);


        $admin_2 = User::create([
            'name' => 'Karin Hair',
            'email' => 'kayisanta5@gmail.com',
            'username' => 'kchozo27',
            'local_id' => 5,
            'password' => Hash::make('12345678'),
            'status' => 1,
        ]);
        $admin_2->assignRole($adminRole);

        $almacen_1 = User::create([
            'name' => 'Renato Moran',
            'email' => 'renato123@gmail.com',
            'username' => 'renato20',
            'local_id' => 6,
            'password' => Hash::make('12345678'),
            'status' => 1,
        ]);
        $almacen_1->assignRole($adminRole);

        $auditor_1 = User::create([
            'name' => 'Jeferson Coveñas',
            'email' => 'jeferson321@gmail.com',
            'username' => 'jeferson32',
            'local_id' => 2,
            'password' => Hash::make('12345678'),
            'status' => 1,
        ]);
        $auditor_1->assignRole($adminRole);

        $admin_3 = User::create([
            'name' => 'Pablo Lupu',
            'email' => 'pablolupu2020@gmail.com',
            'username' => 'PabloLupu',
            'local_id' => 2,
            'password' => Hash::make('12345678'),
            'status' => 1,
        ]);
        $admin_3->assignRole($adminRole);

        $admin_4 = User::create([
            'name' => 'Anthony Marck',
            'email' => 'thonymarck385213xd@gmail.com',
            'username' => 'thonymarck',
            'local_id' => 5,
            'password' => Hash::make('12345678'),
            'status' => 1,
        ]);
        $admin_4->assignRole($adminRole);

        $admin_5 = User::create([
            'name' => 'Gustavo Siancas',
            'email' => 'gustavo@gmail.com',
            'username' => 'gustavo25',
            'local_id' => 1,
            'password' => Hash::make('12345678'),
            'status' => 1,
        ]);
        $admin_5->assignRole($adminRole);


        $admin_6 = User::create([
            'name' => 'Prueba 1',
            'email' => 'prueba1@gmail.com',
            'username' => 'prueba1',
            'local_id' => 3,
            'password' => Hash::make('12345678'),
            'status' => 1,
        ]);

        $admin_6->assignRole($adminRole);
      
        $admin_7 = User::create([
            'name' => 'Prueba 2',
            'email' => 'prueba2@gmail.com',
            'username' => 'prueba2',
            'local_id' => 4,
            'password' => Hash::make('12345678'),
            'status' => 1,
        ]);
        $admin_7->assignRole($adminRole);
      
        $admin_8 = User::create([
            'name' => 'Prueba 3',
            'email' => 'prueba3@gmail.com',
            'username' => 'prueba3',
            'local_id' => 5,
            'password' => Hash::make('12345678'),
            'status' => 1,
        ]);
      
        $admin_8->assignRole($adminRole);
      
         $admin_9 = User::create([
            'name' => 'Jorge Arce',
            'email' => 'prueba@gmail.com',
            'username' => 'jorgearce',
            'local_id' => 6,
            'password' => Hash::make('12345678'),
            'status' => 1,
        ]);
        $admin_9->assignRole($adminRole);
    }
}
