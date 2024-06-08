<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define permissions
        $permissions = [
            'Browse Story',
            'Purchase Story',
            'Create Story',
            'Rate Story',
            'Sale Story',
            'Moderate Story',
            'Manage User',
            'Give Permission',
            'Assign Role',
            'create categories',
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create roles
        $userRole = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

        // Assign permissions to roles
        $userPermissions = [
            'Browse Story',
            'Purchase Story',
            'Create Story',
            'Rate Story',
            'Sale Story',
        ];

        $adminPermissions = [
            'Moderate Story',
            'Manage User',
            'Give Permission',
            'Assign Role',
            'create categories',
        ];

        // Assign user permissions to user role
        foreach ($userPermissions as $permission) {
            $userRole->givePermissionTo($permission);
        }

        // Assign admin permissions to admin role
        foreach ($adminPermissions as $permission) {
            $adminRole->givePermissionTo($permission);
        }
    }
}
