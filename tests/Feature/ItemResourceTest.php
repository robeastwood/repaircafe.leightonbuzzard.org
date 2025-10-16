<?php

declare(strict_types=1);

use App\Filament\Resources\Items\Pages\CreateItem;
use App\Filament\Resources\Items\Pages\EditItem;
use App\Filament\Resources\Items\Pages\ViewItem;
use App\Models\Category;
use App\Models\Item;
use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Filament\Facades\Filament;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;

use function Pest\Laravel\assertDatabaseHas;

beforeEach(function () {
    Filament::setCurrentPanel('admin');
    Permission::firstOrCreate(['name' => 'access-admin-panel', 'guard_name' => 'web']);
    Permission::firstOrCreate(['name' => 'manage-items', 'guard_name' => 'web']);

    Category::factory()->create();
});

describe('Item Policy - View Permissions', function () {
    test('any authenticated user can view items list', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo('access-admin-panel');

        $this->actingAs($user);

        expect(\App\Filament\Resources\Items\ItemResource::canViewAny())->toBeTrue();
    });

    test('any authenticated user can view individual item', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo('access-admin-panel');

        $item = Item::factory()->create(['user_id' => $user->id]);

        Livewire::actingAs($user)
            ->test(ViewItem::class, ['record' => $item->id])
            ->assertSuccessful();
    });

    test('user can view items they do not own', function () {
        $owner = User::factory()->create(['email_verified_at' => now()]);
        $viewer = User::factory()->create(['email_verified_at' => now()]);
        $viewer->givePermissionTo('access-admin-panel');

        $item = Item::factory()->create(['user_id' => $owner->id]);

        Livewire::actingAs($viewer)
            ->test(ViewItem::class, ['record' => $item->id])
            ->assertSuccessful();
    });
});

describe('Item Policy - Create Permissions', function () {
    test('user with manage-items permission can access create page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-items']);

        Livewire::actingAs($user)
            ->test(CreateItem::class)
            ->assertSuccessful();
    });

    test('user without manage-items permission cannot access create page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo('access-admin-panel');

        Livewire::actingAs($user)
            ->test(CreateItem::class)
            ->assertForbidden();
    });

    test('user with manage-items permission can create item', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-items']);

        $category = Category::first();

        Livewire::actingAs($user)
            ->test(CreateItem::class)
            ->fillForm([
                'user_id' => $user->id,
                'category_id' => $category->id,
                'description' => 'Test Item',
                'issue' => 'Test Issue',
                'status' => 'broken',
                'powered' => 'mains',
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        assertDatabaseHas(Item::class, [
            'description' => 'Test Item',
            'issue' => 'Test Issue',
        ]);
    });
});

describe('Item Policy - Update Permissions', function () {
    test('item owner can access edit page for their own item', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo('access-admin-panel');

        $item = Item::factory()->create(['user_id' => $user->id]);

        Livewire::actingAs($user)
            ->test(EditItem::class, ['record' => $item->id])
            ->assertSuccessful();
    });

    test('user with manage-items permission can access edit page for any item', function () {
        $owner = User::factory()->create(['email_verified_at' => now()]);
        $admin = User::factory()->create(['email_verified_at' => now()]);
        $admin->givePermissionTo(['access-admin-panel', 'manage-items']);

        $item = Item::factory()->create(['user_id' => $owner->id]);

        Livewire::actingAs($admin)
            ->test(EditItem::class, ['record' => $item->id])
            ->assertSuccessful();
    });

    test('user without permission cannot access edit page for other users items', function () {
        $owner = User::factory()->create(['email_verified_at' => now()]);
        $otherUser = User::factory()->create(['email_verified_at' => now()]);
        $otherUser->givePermissionTo('access-admin-panel');

        $item = Item::factory()->create(['user_id' => $owner->id]);

        Livewire::actingAs($otherUser)
            ->test(EditItem::class, ['record' => $item->id])
            ->assertForbidden();
    });

    test('item owner can update their own item', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo('access-admin-panel');

        $item = Item::factory()->create([
            'user_id' => $user->id,
            'description' => 'Original Description',
        ]);

        Livewire::actingAs($user)
            ->test(EditItem::class, ['record' => $item->id])
            ->fillForm([
                'description' => 'Updated Description',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        assertDatabaseHas(Item::class, [
            'id' => $item->id,
            'description' => 'Updated Description',
        ]);
    });

    test('user with manage-items permission can update any item', function () {
        $owner = User::factory()->create(['email_verified_at' => now()]);
        $admin = User::factory()->create(['email_verified_at' => now()]);
        $admin->givePermissionTo(['access-admin-panel', 'manage-items']);

        $item = Item::factory()->create([
            'user_id' => $owner->id,
            'description' => 'Original Description',
        ]);

        Livewire::actingAs($admin)
            ->test(EditItem::class, ['record' => $item->id])
            ->fillForm([
                'description' => 'Updated by Admin',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        assertDatabaseHas(Item::class, [
            'id' => $item->id,
            'description' => 'Updated by Admin',
        ]);
    });
});

describe('Item Policy - Delete Permissions', function () {
    test('item owner can delete their own item', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo('access-admin-panel');

        $item = Item::factory()->create(['user_id' => $user->id]);

        Livewire::actingAs($user)
            ->test(EditItem::class, ['record' => $item->id])
            ->callAction(TestAction::make('delete'));

        expect(Item::find($item->id))->toBeNull();
    });

    test('user with manage-items permission can delete any item', function () {
        $owner = User::factory()->create(['email_verified_at' => now()]);
        $admin = User::factory()->create(['email_verified_at' => now()]);
        $admin->givePermissionTo(['access-admin-panel', 'manage-items']);

        $item = Item::factory()->create(['user_id' => $owner->id]);

        Livewire::actingAs($admin)
            ->test(EditItem::class, ['record' => $item->id])
            ->callAction(TestAction::make('delete'));

        expect(Item::find($item->id))->toBeNull();
    });

    test('user without permission cannot delete other users items', function () {
        $owner = User::factory()->create(['email_verified_at' => now()]);
        $otherUser = User::factory()->create(['email_verified_at' => now()]);
        $otherUser->givePermissionTo('access-admin-panel');

        $item = Item::factory()->create(['user_id' => $owner->id]);

        Livewire::actingAs($otherUser)
            ->test(EditItem::class, ['record' => $item->id])
            ->assertForbidden();
    });
});

describe('Item Policy - View Page Actions', function () {
    test('item owner sees edit and delete actions on view page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo('access-admin-panel');

        $item = Item::factory()->create(['user_id' => $user->id]);

        Livewire::actingAs($user)
            ->test(ViewItem::class, ['record' => $item->id])
            ->assertActionVisible('edit')
            ->assertActionVisible('delete');
    });

    test('user with manage-items permission sees edit and delete actions on view page', function () {
        $owner = User::factory()->create(['email_verified_at' => now()]);
        $admin = User::factory()->create(['email_verified_at' => now()]);
        $admin->givePermissionTo(['access-admin-panel', 'manage-items']);

        $item = Item::factory()->create(['user_id' => $owner->id]);

        Livewire::actingAs($admin)
            ->test(ViewItem::class, ['record' => $item->id])
            ->assertActionVisible('edit')
            ->assertActionVisible('delete');
    });

    test('user without permission does not see edit and delete actions on view page', function () {
        $owner = User::factory()->create(['email_verified_at' => now()]);
        $viewer = User::factory()->create(['email_verified_at' => now()]);
        $viewer->givePermissionTo('access-admin-panel');

        $item = Item::factory()->create(['user_id' => $owner->id]);

        Livewire::actingAs($viewer)
            ->test(ViewItem::class, ['record' => $item->id])
            ->assertActionHidden('edit')
            ->assertActionHidden('delete');
    });
});

describe('Item View - Deleted Status', function () {
    test('view page shows DELETED badge in title for soft deleted items', function () {
        Permission::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']);

        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'super-admin']);

        $item = Item::factory()->create(['user_id' => $user->id]);
        $item->delete();

        Livewire::actingAs($user)
            ->test(ViewItem::class, ['record' => $item->id])
            ->assertSee('DELETED')
            ->assertSee('Item ID: '.$item->id);
    });

    test('view page does not show DELETED badge for active items', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo('access-admin-panel');

        $item = Item::factory()->create(['user_id' => $user->id]);

        Livewire::actingAs($user)
            ->test(ViewItem::class, ['record' => $item->id])
            ->assertDontSee('DELETED')
            ->assertSee('Item ID: '.$item->id);
    });
});
