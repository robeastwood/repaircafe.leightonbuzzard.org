<?php

declare(strict_types=1);

use App\Filament\Resources\Roles\Pages\CreateRole;
use App\Filament\Resources\Roles\Pages\EditRole;
use App\Filament\Resources\Roles\Pages\ListRoles;
use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Filament\Facades\Filament;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

use function Pest\Laravel\assertDatabaseHas;

beforeEach(function () {
    Filament::setCurrentPanel('admin');
    Permission::firstOrCreate(['name' => 'access-admin-panel', 'guard_name' => 'web']);
    Permission::firstOrCreate(['name' => 'manage-permissions', 'guard_name' => 'web']);
    Permission::firstOrCreate(['name' => 'manage-venues', 'guard_name' => 'web']);
    Permission::firstOrCreate(['name' => 'manage-events', 'guard_name' => 'web']);
});

describe('Role Resource Authorization', function () {
    test('users with manage-permissions permission can see roles in navigation', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-permissions']);

        $this->actingAs($user);

        expect(\App\Filament\Resources\Roles\RoleResource::canViewAny())->toBeTrue();
    });

    test('users without manage-permissions permission cannot see roles in navigation', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo('access-admin-panel');

        $this->actingAs($user);

        expect(\App\Filament\Resources\Roles\RoleResource::canViewAny())->toBeFalse();
    });

    test('guest users cannot see roles in navigation', function () {
        expect(\App\Filament\Resources\Roles\RoleResource::canViewAny())->toBeFalse();
    });

    test('users without manage-permissions permission cannot access list page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo('access-admin-panel');

        Livewire::actingAs($user)
            ->test(ListRoles::class)
            ->assertForbidden();
    });

    test('users without manage-permissions permission cannot access create page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo('access-admin-panel');

        Livewire::actingAs($user)
            ->test(CreateRole::class)
            ->assertForbidden();
    });

    test('users without manage-permissions permission cannot access edit page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo('access-admin-panel');

        $role = Role::create(['name' => 'test-role', 'guard_name' => 'web']);

        Livewire::actingAs($user)
            ->test(EditRole::class, ['record' => $role->id])
            ->assertForbidden();
    });
});

describe('List Roles', function () {
    test('can render list roles page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-permissions']);

        Livewire::actingAs($user)
            ->test(ListRoles::class)
            ->assertSuccessful();
    });

    test('can list roles', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-permissions']);

        $roles = [
            Role::create(['name' => 'admin', 'guard_name' => 'web']),
            Role::create(['name' => 'editor', 'guard_name' => 'web']),
            Role::create(['name' => 'viewer', 'guard_name' => 'web']),
        ];

        Livewire::actingAs($user)
            ->test(ListRoles::class)
            ->assertCanSeeTableRecords($roles);
    });

    test('can search roles by name', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-permissions']);

        $roles = [
            Role::create(['name' => 'super-admin', 'guard_name' => 'web']),
            Role::create(['name' => 'editor', 'guard_name' => 'web']),
            Role::create(['name' => 'viewer', 'guard_name' => 'web']),
        ];

        Livewire::actingAs($user)
            ->test(ListRoles::class)
            ->searchTable('super')
            ->assertCanSeeTableRecords([$roles[0]])
            ->assertCanNotSeeTableRecords([$roles[1], $roles[2]]);
    });
});

describe('Create Role', function () {
    test('can render create role page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-permissions']);

        Livewire::actingAs($user)
            ->test(CreateRole::class)
            ->assertSuccessful();
    });

    test('can create role with permissions', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-permissions']);

        $manageVenuesPermission = Permission::where('name', 'manage-venues')->first();
        $manageEventsPermission = Permission::where('name', 'manage-events')->first();

        $newRole = [
            'name' => 'venue-manager',
            'permissions' => [$manageVenuesPermission->id, $manageEventsPermission->id],
        ];

        Livewire::actingAs($user)
            ->test(CreateRole::class)
            ->fillForm($newRole)
            ->call('create')
            ->assertHasNoFormErrors();

        assertDatabaseHas(Role::class, ['name' => 'venue-manager']);

        $role = Role::where('name', 'venue-manager')->first();
        expect($role->permissions->pluck('id')->toArray())->toEqual($newRole['permissions']);
    });

    test('can validate required fields when creating role', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-permissions']);

        Livewire::actingAs($user)
            ->test(CreateRole::class)
            ->fillForm([
                'name' => '',
            ])
            ->call('create')
            ->assertHasFormErrors(['name' => 'required']);
    });

    test('validates unique role name', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-permissions']);

        Role::create(['name' => 'existing-role', 'guard_name' => 'web']);

        Livewire::actingAs($user)
            ->test(CreateRole::class)
            ->fillForm([
                'name' => 'existing-role',
            ])
            ->call('create')
            ->assertHasFormErrors(['name' => 'unique']);
    });
});

describe('Edit Role', function () {
    test('can render edit role page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-permissions']);

        $role = Role::create(['name' => 'test-role', 'guard_name' => 'web']);

        Livewire::actingAs($user)
            ->test(EditRole::class, ['record' => $role->id])
            ->assertSuccessful();
    });

    test('can retrieve role data in edit form', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-permissions']);

        $manageVenuesPermission = Permission::where('name', 'manage-venues')->first();
        $role = Role::create(['name' => 'original-role', 'guard_name' => 'web']);
        $role->givePermissionTo($manageVenuesPermission);

        Livewire::actingAs($user)
            ->test(EditRole::class, ['record' => $role->id])
            ->assertSchemaStateSet([
                'name' => 'original-role',
                'permissions' => [$manageVenuesPermission->id],
            ]);
    });

    test('can update role', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-permissions']);

        $role = Role::create(['name' => 'old-role', 'guard_name' => 'web']);
        $manageEventsPermission = Permission::where('name', 'manage-events')->first();

        $updatedData = [
            'name' => 'updated-role',
            'permissions' => [$manageEventsPermission->id],
        ];

        Livewire::actingAs($user)
            ->test(EditRole::class, ['record' => $role->id])
            ->fillForm($updatedData)
            ->call('save')
            ->assertHasNoFormErrors();

        assertDatabaseHas(Role::class, ['name' => 'updated-role']);

        $role->refresh();
        expect($role->permissions->pluck('id')->toArray())->toEqual($updatedData['permissions']);
    });

    test('can validate required fields when updating role', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-permissions']);

        $role = Role::create(['name' => 'test-role', 'guard_name' => 'web']);

        Livewire::actingAs($user)
            ->test(EditRole::class, ['record' => $role->id])
            ->fillForm([
                'name' => '',
            ])
            ->call('save')
            ->assertHasFormErrors(['name' => 'required']);
    });

    test('validates unique role name when updating but allows same name', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-permissions']);

        Role::create(['name' => 'other-role', 'guard_name' => 'web']);
        $role = Role::create(['name' => 'test-role', 'guard_name' => 'web']);

        Livewire::actingAs($user)
            ->test(EditRole::class, ['record' => $role->id])
            ->fillForm([
                'name' => 'other-role',
            ])
            ->call('save')
            ->assertHasFormErrors(['name' => 'unique']);

        Livewire::actingAs($user)
            ->test(EditRole::class, ['record' => $role->id])
            ->fillForm([
                'name' => 'test-role',
            ])
            ->call('save')
            ->assertHasNoFormErrors();
    });
});

describe('Delete Role', function () {
    test('can delete role from edit page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-permissions']);

        $role = Role::create(['name' => 'role-to-delete', 'guard_name' => 'web']);

        Livewire::actingAs($user)
            ->test(EditRole::class, ['record' => $role->id])
            ->callAction(TestAction::make('delete'));

        expect(Role::find($role->id))->toBeNull();
    });

    test('can bulk delete roles from list page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-permissions']);

        $role1 = Role::create(['name' => 'role-to-delete-1', 'guard_name' => 'web']);
        $role2 = Role::create(['name' => 'role-to-delete-2', 'guard_name' => 'web']);

        Livewire::actingAs($user)
            ->test(ListRoles::class)
            ->selectTableRecords([$role1->id, $role2->id])
            ->callAction(TestAction::make('delete')->table()->bulk());

        expect(Role::find($role1->id))->toBeNull();
        expect(Role::find($role2->id))->toBeNull();
    });
});

describe('Role Relationships', function () {
    test('deleting role removes user associations', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $role = Role::create(['name' => 'test-role', 'guard_name' => 'web']);
        $user->assignRole($role);

        expect($user->hasRole('test-role'))->toBeTrue();

        $role->delete();

        $user->refresh();
        expect($user->hasRole('test-role'))->toBeFalse();
    });

    test('role can have multiple permissions', function () {
        $role = Role::create(['name' => 'multi-permission-role', 'guard_name' => 'web']);
        $permissions = Permission::whereIn('name', ['manage-venues', 'manage-events'])->get();

        $role->givePermissionTo($permissions);

        expect($role->permissions)->toHaveCount(2);
        expect($role->hasPermissionTo('manage-venues'))->toBeTrue();
        expect($role->hasPermissionTo('manage-events'))->toBeTrue();
    });
});
