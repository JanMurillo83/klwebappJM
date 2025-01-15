<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear o recuperar roles
        $roleAdmin = Role::firstOrCreate(['name' => 'admin']);
        $roleCoordinator = Role::firstOrCreate(['name' => 'coordinator']);

        // Permisos comunes a ambos roles
        $permissionsCommon = [
            'dashboard',
        ];

        // Permisos exclusivos de admin
        $permissionsAdmin = [
            'catalog.index',
            'users.index', 
            'users.edit', 
            'users.destroy',
            'business-directory.index',
        ];

        // Asignar permisos comunes
        foreach ($permissionsCommon as $permission) {
            $perm = Permission::firstOrCreate(['name' => $permission]);
            $perm->syncRoles([$roleAdmin, $roleCoordinator]);
        }

        // Asignar permisos específicos de admin
        foreach ($permissionsAdmin as $permission) {
            $perm = Permission::firstOrCreate(['name' => $permission]);
            $perm->assignRole($roleAdmin);
        }
    }


}
