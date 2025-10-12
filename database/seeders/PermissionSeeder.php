<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions
        $permissions = [
            'access-admin-panel',
            'item-check-in',
            'add-skills',
            'add-notes',
            'can-fix',
            'can-volunteer',
            'update-item-status',
            'manage-venues',
            'manage-items',
            'manage-users',
            'manage-permissions',
            'manage-events',
            'manage-skills',
            'manage-categories',
            'manage-notifications',
            'email-event-attendees',
            'email-users',
            'email-newsletters',
            'manage-reports',
            'view-reports',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission],
                ['guard_name' => 'web']
            );
        }

        $this->command->info('Permissions created successfully.');

        // create admin role if not exists
        $adminRole = Role::firstOrCreate(['name' => 'admin'], ['guard_name' => 'web']);
        // all permissions
        $adminRole->givePermissionTo($permissions);
        $this->command->info('Admin role created successfully.');

        // create fixer role if not exists
        $fixerRole = Role::firstOrCreate(['name' => 'fixer'], ['guard_name' => 'web']);
        $fixerRole->givePermissionTo(['update-item-status', 'add-skills', 'add-notes', 'can-fix']);
        $this->command->info('Fixer role created successfully.');

        // create volunteer role if not exists
        $volunteerRole = Role::firstOrCreate(['name' => 'volunteer'], ['guard_name' => 'web']);
        $volunteerRole->givePermissionTo(['item-check-in', 'update-item-status', 'add-notes', 'can-volunteer']);
        $this->command->info('Volunteer role created successfully.');

    }
}
