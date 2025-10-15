<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

/**
 * This seeder is used to sync the permissions with the database.
 * It is the only seeder that should be run in production environments, whenever the permissions are changed.
 */
class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // valid permissions
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
            'view-reports',
            'manage-reports',
            'super-admin',
        ];

        $created = 0;
        $existing = 0;

        foreach ($permissions as $permission) {
            $permissionModel = Permission::firstOrCreate(
                ['name' => $permission],
                ['guard_name' => 'web']
            );

            if ($permissionModel->wasRecentlyCreated) {
                $this->command->info("Added new permission: {$permission}");
                $created++;
            } else {
                $existing++;
            }
        }

        // remove any permissions that are in the db but not in the $permissions array
        $orphaned = Permission::whereNotIn('name', $permissions)->get();
        if ($orphaned->isNotEmpty()) {
            foreach ($orphaned as $orphanedPermission) {
                $this->command->warn("Deleted removed permission: {$orphanedPermission->name}");
            }
            $orphaned->each->delete();
        }

        $this->command->info("Permissions processed: {$created} created, {$existing} existing".($orphaned->isNotEmpty() ? ", {$orphaned->count()} deleted" : ''));
    }
}
