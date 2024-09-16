<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Crear permisos si no existen
        $permissions = [
            'manage users',
            'manage technicians',
            'manage consultas',
            'manage notificaciones',
            'view general'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Crear roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $supervisorN2Role = Role::firstOrCreate(['name' => 'supervisor n2']);
        $supervisorN1Role = Role::firstOrCreate(['name' => 'supervisor n1']);
        $operatorN1Role = Role::firstOrCreate(['name' => 'operador n1']);
        $operatorN2Role = Role::firstOrCreate(['name' => 'operador n2']);

        // Asignar permisos a roles
        $adminRole->givePermissionTo(Permission::all()); // Admin tiene todos los permisos
        $supervisorN2Role->givePermissionTo(Permission::all()); // Supervisor n2 tiene todos los permisos
        $supervisorN1Role->givePermissionTo(Permission::all());

        // Asignar permisos específicos a otros roles
        $operatorN1Role->givePermissionTo(['view general']);
        $operatorN2Role->givePermissionTo(['view general']);
    }
}