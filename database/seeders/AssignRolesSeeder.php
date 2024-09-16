<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AssignRolesSeeder extends Seeder
{
    public function run()
    {
        // Crear roles si no existen
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Asignar roles a usuarios específicos
        $adminUser = User::find(1); // Reemplaza con el ID del usuario que deseas asignar
        if ($adminUser) {
            $adminUser->assignRole($adminRole);
        }

        // Puedes asignar roles a otros usuarios de manera similar
        $regularUser = User::find(2); // Reemplaza con el ID del usuario
        if ($regularUser) {
            $regularUser->assignRole($userRole);
        }
    }
}