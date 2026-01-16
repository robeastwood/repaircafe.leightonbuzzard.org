<?php

declare(strict_types=1);

use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Filament\Resources\Users\Pages\ViewUser;
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
    Permission::firstOrCreate(['name' => 'manage-users', 'guard_name' => 'web']);
    Permission::firstOrCreate(['name' => 'manage-permissions', 'guard_name' => 'web']);
    Permission::firstOrCreate(['name' => 'can-fix', 'guard_name' => 'web']);
});

describe('User Resource Authorization', function () {
    test('users with manage-users permission can see users in navigation', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-users']);

        $this->actingAs($user);

        expect(\App\Filament\Resources\Users\UserResource::canViewAny())->toBeTrue();
    });

    test('users without manage-users permission cannot see users in navigation', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo('access-admin-panel');

        $this->actingAs($user);

        expect(\App\Filament\Resources\Users\UserResource::canViewAny())->toBeFalse();
    });

    test('guest users cannot see users in navigation', function () {
        expect(\App\Filament\Resources\Users\UserResource::canViewAny())->toBeFalse();
    });

    test('users without manage-users permission cannot access list page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo('access-admin-panel');

        Livewire::actingAs($user)
            ->test(ListUsers::class)
            ->assertForbidden();
    });

    test('users without manage-users permission cannot access create page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo('access-admin-panel');

        Livewire::actingAs($user)
            ->test(CreateUser::class)
            ->assertForbidden();
    });

    test('users without manage-users permission cannot access view page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo('access-admin-panel');

        $targetUser = User::factory()->create(['email_verified_at' => now()]);

        Livewire::actingAs($user)
            ->test(ViewUser::class, ['record' => $targetUser->id])
            ->assertForbidden();
    });

    test('users without manage-users permission cannot access edit page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo('access-admin-panel');

        $targetUser = User::factory()->create(['email_verified_at' => now()]);

        Livewire::actingAs($user)
            ->test(EditUser::class, ['record' => $targetUser->id])
            ->assertForbidden();
    });
});

describe('List Users', function () {
    test('can render list users page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-users']);

        Livewire::actingAs($user)
            ->test(ListUsers::class)
            ->assertSuccessful();
    });

    test('can list users', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-users']);

        $users = [
            User::factory()->create(['name' => 'John Doe', 'email_verified_at' => now()]),
            User::factory()->create(['name' => 'Jane Smith', 'email_verified_at' => now()]),
            User::factory()->create(['name' => 'Bob Johnson', 'email_verified_at' => now()]),
        ];

        Livewire::actingAs($user)
            ->test(ListUsers::class)
            ->assertCanSeeTableRecords($users);
    });

    test('does not list users with unverified emails', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-users']);

        $verifiedUsers = [
            User::factory()->create(['name' => 'Verified User 1', 'email_verified_at' => now()]),
            User::factory()->create(['name' => 'Verified User 2', 'email_verified_at' => now()]),
        ];

        $unverifiedUsers = [
            User::factory()->create(['name' => 'Unverified User 1', 'email_verified_at' => null]),
            User::factory()->create(['name' => 'Unverified User 2', 'email_verified_at' => null]),
        ];

        Livewire::actingAs($user)
            ->test(ListUsers::class)
            ->assertCanSeeTableRecords($verifiedUsers)
            ->assertCanNotSeeTableRecords($unverifiedUsers);
    });

    test('can search users by name', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-users']);

        $users = [
            User::factory()->create(['name' => 'Super Admin User', 'email_verified_at' => now()]),
            User::factory()->create(['name' => 'Regular User', 'email_verified_at' => now()]),
            User::factory()->create(['name' => 'Guest User', 'email_verified_at' => now()]),
        ];

        Livewire::actingAs($user)
            ->test(ListUsers::class)
            ->searchTable('Super')
            ->assertCanSeeTableRecords([$users[0]])
            ->assertCanNotSeeTableRecords([$users[1], $users[2]]);
    });

    test('can search users by email', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-users']);

        $users = [
            User::factory()->create(['email' => 'admin@example.com', 'email_verified_at' => now()]),
            User::factory()->create(['email' => 'user@example.com', 'email_verified_at' => now()]),
            User::factory()->create(['email' => 'guest@example.com', 'email_verified_at' => now()]),
        ];

        Livewire::actingAs($user)
            ->test(ListUsers::class)
            ->searchTable('admin@')
            ->assertCanSeeTableRecords([$users[0]])
            ->assertCanNotSeeTableRecords([$users[1], $users[2]]);
    });

    test('can filter to show only unverified users', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-users']);

        $verifiedUsers = [
            User::factory()->create(['name' => 'Verified User 1', 'email_verified_at' => now()]),
            User::factory()->create(['name' => 'Verified User 2', 'email_verified_at' => now()]),
        ];

        $unverifiedUsers = [
            User::factory()->create(['name' => 'Unverified User 1', 'email_verified_at' => null]),
            User::factory()->create(['name' => 'Unverified User 2', 'email_verified_at' => null]),
        ];

        Livewire::actingAs($user)
            ->test(ListUsers::class)
            ->filterTable('email_verified_at', false)
            ->assertCanSeeTableRecords($unverifiedUsers)
            ->assertCanNotSeeTableRecords($verifiedUsers);
    });

    test('can filter to show all users', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-users']);

        $verifiedUsers = [
            User::factory()->create(['name' => 'Verified User', 'email_verified_at' => now()]),
        ];

        $unverifiedUsers = [
            User::factory()->create(['name' => 'Unverified User', 'email_verified_at' => null]),
        ];

        Livewire::actingAs($user)
            ->test(ListUsers::class)
            ->filterTable('email_verified_at', true)
            ->assertCanSeeTableRecords($verifiedUsers)
            ->assertCanSeeTableRecords($unverifiedUsers);
    });

    test('can filter users by role', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-users']);

        $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $editorRole = Role::create(['name' => 'editor', 'guard_name' => 'web']);

        $adminUsers = [
            User::factory()->create(['name' => 'Admin User 1', 'email_verified_at' => now()]),
            User::factory()->create(['name' => 'Admin User 2', 'email_verified_at' => now()]),
        ];
        foreach ($adminUsers as $adminUser) {
            $adminUser->assignRole($adminRole);
        }

        $editorUsers = [
            User::factory()->create(['name' => 'Editor User', 'email_verified_at' => now()]),
        ];
        $editorUsers[0]->assignRole($editorRole);

        $noRoleUsers = [
            User::factory()->create(['name' => 'No Role User', 'email_verified_at' => now()]),
        ];

        Livewire::actingAs($user)
            ->test(ListUsers::class)
            ->filterTable('role', ['admin'])
            ->assertCanSeeTableRecords($adminUsers)
            ->assertCanNotSeeTableRecords($editorUsers)
            ->assertCanNotSeeTableRecords($noRoleUsers);
    });

    test('can filter users by multiple roles', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-users']);

        $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $editorRole = Role::create(['name' => 'editor', 'guard_name' => 'web']);
        $viewerRole = Role::create(['name' => 'viewer', 'guard_name' => 'web']);

        $adminUser = User::factory()->create(['name' => 'Admin User', 'email_verified_at' => now()]);
        $adminUser->assignRole($adminRole);

        $editorUser = User::factory()->create(['name' => 'Editor User', 'email_verified_at' => now()]);
        $editorUser->assignRole($editorRole);

        $viewerUser = User::factory()->create(['name' => 'Viewer User', 'email_verified_at' => now()]);
        $viewerUser->assignRole($viewerRole);

        Livewire::actingAs($user)
            ->test(ListUsers::class)
            ->filterTable('role', ['admin', 'editor'])
            ->assertCanSeeTableRecords([$adminUser, $editorUser])
            ->assertCanNotSeeTableRecords([$viewerUser]);
    });
});

describe('View User', function () {
    test('can render view user page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-users']);

        $targetUser = User::factory()->create(['email_verified_at' => now()]);

        Livewire::actingAs($user)
            ->test(ViewUser::class, ['record' => $targetUser->id])
            ->assertSuccessful();
    });

    test('view page displays user information', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-users']);

        $targetUser = User::factory()->create([
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'email_verified_at' => now(),
        ]);

        Livewire::actingAs($user)
            ->test(ViewUser::class, ['record' => $targetUser->id])
            ->assertSee('Test User')
            ->assertSee('testuser@example.com');
    });
});

describe('Create User', function () {
    test('can render create user page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-users']);

        Livewire::actingAs($user)
            ->test(CreateUser::class)
            ->assertSuccessful();
    });

    test('can create user', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-users']);

        $newUser = [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'password' => 'password123',
        ];

        Livewire::actingAs($user)
            ->test(CreateUser::class)
            ->fillForm($newUser)
            ->call('create')
            ->assertHasNoFormErrors();

        assertDatabaseHas(User::class, [
            'name' => 'New User',
            'email' => 'newuser@example.com',
        ]);
    });

    test('can create user with roles', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-users']);

        $role = Role::create(['name' => 'test-role', 'guard_name' => 'web']);

        $newUser = [
            'name' => 'User With Role',
            'email' => 'userrole@example.com',
            'password' => 'password123',
            'roles' => [$role->id],
        ];

        Livewire::actingAs($user)
            ->test(CreateUser::class)
            ->fillForm($newUser)
            ->call('create')
            ->assertHasNoFormErrors();

        $createdUser = User::where('email', 'userrole@example.com')->first();
        expect($createdUser->hasRole('test-role'))->toBeTrue();
    });

    test('can validate required fields when creating user', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-users']);

        Livewire::actingAs($user)
            ->test(CreateUser::class)
            ->fillForm([
                'name' => '',
                'email' => '',
                'password' => '',
            ])
            ->call('create')
            ->assertHasFormErrors(['name' => 'required', 'email' => 'required', 'password' => 'required']);
    });

    test('validates unique email when creating user', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-users']);

        User::factory()->create(['email' => 'existing@example.com', 'email_verified_at' => now()]);

        Livewire::actingAs($user)
            ->test(CreateUser::class)
            ->fillForm([
                'name' => 'Test User',
                'email' => 'existing@example.com',
                'password' => 'password123',
            ])
            ->call('create')
            ->assertHasFormErrors(['email' => 'unique']);
    });

    test('validates email format when creating user', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-users']);

        Livewire::actingAs($user)
            ->test(CreateUser::class)
            ->fillForm([
                'name' => 'Test User',
                'email' => 'invalid-email',
                'password' => 'password123',
            ])
            ->call('create')
            ->assertHasFormErrors(['email' => 'email']);
    });
});

describe('Edit User', function () {
    test('can render edit user page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-users']);

        $targetUser = User::factory()->create(['email_verified_at' => now()]);

        Livewire::actingAs($user)
            ->test(EditUser::class, ['record' => $targetUser->id])
            ->assertSuccessful();
    });

    test('can retrieve user data in edit form', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-users']);

        $targetUser = User::factory()->create([
            'name' => 'Original Name',
            'email' => 'original@example.com',
            'email_verified_at' => now(),
        ]);

        Livewire::actingAs($user)
            ->test(EditUser::class, ['record' => $targetUser->id])
            ->assertSchemaStateSet([
                'name' => 'Original Name',
                'email' => 'original@example.com',
            ]);
    });

    test('can update user', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-users']);

        $targetUser = User::factory()->create([
            'name' => 'Old Name',
            'email' => 'old@example.com',
            'email_verified_at' => now(),
        ]);

        $updatedData = [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ];

        Livewire::actingAs($user)
            ->test(EditUser::class, ['record' => $targetUser->id])
            ->fillForm($updatedData)
            ->call('save')
            ->assertHasNoFormErrors();

        assertDatabaseHas(User::class, [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);
    });

    test('can update user without changing password', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-users']);

        $targetUser = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'email_verified_at' => now(),
        ]);
        $originalPassword = $targetUser->password;

        Livewire::actingAs($user)
            ->test(EditUser::class, ['record' => $targetUser->id])
            ->fillForm([
                'name' => 'Updated Name',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $targetUser->refresh();
        expect($targetUser->password)->toBe($originalPassword);
    });

    test('can update user roles', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-users']);

        $role1 = Role::create(['name' => 'role-1', 'guard_name' => 'web']);
        $role2 = Role::create(['name' => 'role-2', 'guard_name' => 'web']);

        $targetUser = User::factory()->create(['email_verified_at' => now()]);
        $targetUser->assignRole($role1);

        Livewire::actingAs($user)
            ->test(EditUser::class, ['record' => $targetUser->id])
            ->fillForm([
                'roles' => [$role2->id],
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $targetUser->refresh();
        expect($targetUser->hasRole('role-1'))->toBeFalse();
        expect($targetUser->hasRole('role-2'))->toBeTrue();
    });

    test('can validate required fields when updating user', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-users']);

        $targetUser = User::factory()->create(['email_verified_at' => now()]);

        Livewire::actingAs($user)
            ->test(EditUser::class, ['record' => $targetUser->id])
            ->fillForm([
                'name' => '',
                'email' => '',
            ])
            ->call('save')
            ->assertHasFormErrors(['name' => 'required', 'email' => 'required']);
    });

    test('validates unique email when updating but allows same email', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-users']);

        User::factory()->create(['email' => 'other@example.com', 'email_verified_at' => now()]);
        $targetUser = User::factory()->create(['email' => 'target@example.com', 'email_verified_at' => now()]);

        Livewire::actingAs($user)
            ->test(EditUser::class, ['record' => $targetUser->id])
            ->fillForm([
                'email' => 'other@example.com',
            ])
            ->call('save')
            ->assertHasFormErrors(['email' => 'unique']);

        Livewire::actingAs($user)
            ->test(EditUser::class, ['record' => $targetUser->id])
            ->fillForm([
                'email' => 'target@example.com',
            ])
            ->call('save')
            ->assertHasNoFormErrors();
    });

    test('changing email invalidates email verification', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-users']);

        $targetUser = User::factory()->create([
            'email' => 'original@example.com',
            'email_verified_at' => now(),
        ]);

        expect($targetUser->email_verified_at)->not->toBeNull();

        Livewire::actingAs($user)
            ->test(EditUser::class, ['record' => $targetUser->id])
            ->fillForm([
                'email' => 'newemail@example.com',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $targetUser->refresh();
        expect($targetUser->email)->toBe('newemail@example.com');
        expect($targetUser->email_verified_at)->toBeNull();
    });

    test('not changing email keeps email verification', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-users']);

        $verifiedAt = now()->subDays(5);
        $targetUser = User::factory()->create([
            'name' => 'Original Name',
            'email' => 'original@example.com',
            'email_verified_at' => $verifiedAt,
        ]);

        Livewire::actingAs($user)
            ->test(EditUser::class, ['record' => $targetUser->id])
            ->fillForm([
                'name' => 'Updated Name',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $targetUser->refresh();
        expect($targetUser->name)->toBe('Updated Name');
        expect($targetUser->email_verified_at)->not->toBeNull();
        expect($targetUser->email_verified_at->timestamp)->toBe($verifiedAt->timestamp);
    });
});

describe('Delete User', function () {
    test('can delete user from edit page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-users']);

        $targetUser = User::factory()->create(['email_verified_at' => now()]);

        Livewire::actingAs($user)
            ->test(EditUser::class, ['record' => $targetUser->id])
            ->callAction(TestAction::make('delete'));

        expect(User::find($targetUser->id))->toBeNull();
    });

    test('can bulk delete users from list page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-users']);

        $user1 = User::factory()->create(['email_verified_at' => now()]);
        $user2 = User::factory()->create(['email_verified_at' => now()]);

        Livewire::actingAs($user)
            ->test(ListUsers::class)
            ->selectTableRecords([$user1->id, $user2->id])
            ->callAction(TestAction::make('delete')->table()->bulk());

        expect(User::find($user1->id))->toBeNull();
        expect(User::find($user2->id))->toBeNull();
    });
});

describe('Items Relation Manager', function () {
    test('can render items relation manager on view user page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-users']);

        $targetUser = User::factory()->create(['email_verified_at' => now()]);

        Livewire::actingAs($user)
            ->test(ViewUser::class, ['record' => $targetUser->id])
            ->assertSuccessful();
    });

    test('can see items belonging to user in relation manager', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-users']);

        $targetUser = User::factory()->create(['email_verified_at' => now()]);
        $category = \App\Models\Category::factory()->create();
        $items = \App\Models\Item::factory()->count(3)->create([
            'user_id' => $targetUser->id,
            'category_id' => $category->id,
        ]);

        Livewire::actingAs($user)
            ->test(\App\Filament\Resources\Users\RelationManagers\ItemsRelationManager::class, [
                'ownerRecord' => $targetUser,
                'pageClass' => ViewUser::class,
            ])
            ->assertCanSeeTableRecords($items);
    });

    test('items relation manager shows correct columns', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-users']);

        $targetUser = User::factory()->create(['email_verified_at' => now()]);
        $category = \App\Models\Category::factory()->create();
        $item = \App\Models\Item::factory()->create([
            'user_id' => $targetUser->id,
            'category_id' => $category->id,
        ]);

        Livewire::actingAs($user)
            ->test(\App\Filament\Resources\Users\RelationManagers\ItemsRelationManager::class, [
                'ownerRecord' => $targetUser,
                'pageClass' => ViewUser::class,
            ])
            ->assertCanSeeTableRecords([$item])
            ->assertTableColumnExists('id')
            ->assertTableColumnExists('description')
            ->assertTableColumnExists('category.name')
            ->assertTableColumnExists('status');
    });
});
