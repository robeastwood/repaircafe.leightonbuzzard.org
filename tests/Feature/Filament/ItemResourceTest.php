<?php

declare(strict_types=1);

use App\Filament\Resources\Items\Pages\CreateItem;
use App\Filament\Resources\Items\Pages\EditItem;
use App\Filament\Resources\Items\Pages\ListItems;
use App\Filament\Resources\Items\Pages\ViewItem;
use App\Models\Category;
use App\Models\Item;
use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Filament\Facades\Filament;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;

beforeEach(function () {
    Filament::setCurrentPanel('admin');
    Permission::firstOrCreate(['name' => 'access-admin-panel', 'guard_name' => 'web']);
    Permission::firstOrCreate(['name' => 'manage-items', 'guard_name' => 'web']);
});

describe('Item Resource Authorization', function () {
    test('authenticated users can see items in navigation', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo('access-admin-panel');

        $this->actingAs($user);

        expect(\App\Filament\Resources\Items\ItemResource::canViewAny())->toBeTrue();
    });

    test('guest users cannot see items in navigation', function () {
        expect(\App\Filament\Resources\Items\ItemResource::canViewAny())->toBeFalse();
    });

    test('authenticated users can access list page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo('access-admin-panel');

        Livewire::actingAs($user)
            ->test(ListItems::class)
            ->assertSuccessful();
    });

    test('authenticated users can access view page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $owner = User::factory()->create(['email_verified_at' => now()]);
        $category = Category::factory()->create();
        $user->givePermissionTo('access-admin-panel');

        $item = Item::factory()->create([
            'user_id' => $owner->id,
            'category_id' => $category->id,
        ]);

        Livewire::actingAs($user)
            ->test(ViewItem::class, ['record' => $item->id])
            ->assertSuccessful();
    });

    test('users without manage-items permission cannot access create page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo('access-admin-panel');

        Livewire::actingAs($user)
            ->test(CreateItem::class)
            ->assertForbidden();
    });

    test('users with manage-items permission can access create page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-items']);

        Livewire::actingAs($user)
            ->test(CreateItem::class)
            ->assertSuccessful();
    });

    test('users without manage-items permission cannot access edit page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $owner = User::factory()->create(['email_verified_at' => now()]);
        $category = Category::factory()->create();
        $user->givePermissionTo('access-admin-panel');

        $item = Item::factory()->create([
            'user_id' => $owner->id,
            'category_id' => $category->id,
        ]);

        Livewire::actingAs($user)
            ->test(EditItem::class, ['record' => $item->id])
            ->assertForbidden();
    });
});

describe('List Items', function () {
    test('can render list items page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo('access-admin-panel');

        Livewire::actingAs($user)
            ->test(ListItems::class)
            ->assertSuccessful();
    });

    test('can list items', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $owner = User::factory()->create(['email_verified_at' => now()]);
        $category = Category::factory()->create();
        $user->givePermissionTo('access-admin-panel');

        $items = Item::factory()->count(3)->create([
            'user_id' => $owner->id,
            'category_id' => $category->id,
        ]);

        Livewire::actingAs($user)
            ->test(ListItems::class)
            ->assertCanSeeTableRecords($items);
    });

    test('can filter items by status', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $owner = User::factory()->create(['email_verified_at' => now()]);
        $category = Category::factory()->create();
        $user->givePermissionTo('access-admin-panel');

        $fixedItem = Item::factory()->create([
            'user_id' => $owner->id,
            'category_id' => $category->id,
            'status' => 'fixed',
        ]);

        $brokenItem = Item::factory()->create([
            'user_id' => $owner->id,
            'category_id' => $category->id,
            'status' => 'broken',
        ]);

        Livewire::actingAs($user)
            ->test(ListItems::class)
            ->filterTable('status', 'fixed')
            ->assertCanSeeTableRecords([$fixedItem])
            ->assertCanNotSeeTableRecords([$brokenItem]);
    });
});

describe('Create Item', function () {
    test('can render create item page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-items']);

        Livewire::actingAs($user)
            ->test(CreateItem::class)
            ->assertSuccessful();
    });

    test('can create item', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $owner = User::factory()->create(['email_verified_at' => now()]);
        $category = Category::factory()->create();
        $user->givePermissionTo(['access-admin-panel', 'manage-items']);

        $newItem = [
            'user_id' => $owner->id,
            'category_id' => $category->id,
            'status' => 'broken',
            'powered' => 'mains',
            'description' => 'Test item description',
            'issue' => 'Test item issue',
        ];

        Livewire::actingAs($user)
            ->test(CreateItem::class)
            ->fillForm($newItem)
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('items', [
            'user_id' => $owner->id,
            'category_id' => $category->id,
            'status' => 'broken',
            'powered' => 'mains',
            'description' => 'Test item description',
            'issue' => 'Test item issue',
        ]);
    });

    test('validates required fields when creating item', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-items']);

        Livewire::actingAs($user)
            ->test(CreateItem::class)
            ->fillForm([
                'user_id' => null,
                'category_id' => null,
                'status' => null,
                'powered' => null,
                'description' => '',
                'issue' => '',
            ])
            ->call('create')
            ->assertHasFormErrors([
                'user_id' => 'required',
                'category_id' => 'required',
                'status' => 'required',
                'powered' => 'required',
                'description' => 'required',
                'issue' => 'required',
            ]);
    });
});

describe('View Item', function () {
    test('can render view item page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $owner = User::factory()->create(['email_verified_at' => now()]);
        $category = Category::factory()->create();
        $user->givePermissionTo('access-admin-panel');

        $item = Item::factory()->create([
            'user_id' => $owner->id,
            'category_id' => $category->id,
        ]);

        Livewire::actingAs($user)
            ->test(ViewItem::class, ['record' => $item->id])
            ->assertSuccessful();
    });

    test('displays item details', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $owner = User::factory()->create(['email_verified_at' => now(), 'name' => 'Test Owner']);
        $category = Category::factory()->create(['name' => 'Test Category']);
        $user->givePermissionTo('access-admin-panel');

        $item = Item::factory()->create([
            'user_id' => $owner->id,
            'category_id' => $category->id,
            'description' => 'Test description',
            'issue' => 'Test issue',
        ]);

        Livewire::actingAs($user)
            ->test(ViewItem::class, ['record' => $item->id])
            ->assertSuccessful()
            ->assertSee('Test Owner')
            ->assertSee('Test Category')
            ->assertSee('Test description')
            ->assertSee('Test issue');
    });
});

describe('Edit Item', function () {
    test('can render edit item page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $owner = User::factory()->create(['email_verified_at' => now()]);
        $category = Category::factory()->create();
        $user->givePermissionTo(['access-admin-panel', 'manage-items']);

        $item = Item::factory()->create([
            'user_id' => $owner->id,
            'category_id' => $category->id,
        ]);

        Livewire::actingAs($user)
            ->test(EditItem::class, ['record' => $item->id])
            ->assertSuccessful();
    });

    test('can update item', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $owner = User::factory()->create(['email_verified_at' => now()]);
        $category = Category::factory()->create();
        $newCategory = Category::factory()->create();
        $user->givePermissionTo(['access-admin-panel', 'manage-items']);

        $item = Item::factory()->create([
            'user_id' => $owner->id,
            'category_id' => $category->id,
            'status' => 'broken',
        ]);

        $updatedData = [
            'category_id' => $newCategory->id,
            'status' => 'fixed',
            'description' => 'Updated description',
            'issue' => 'Updated issue',
        ];

        Livewire::actingAs($user)
            ->test(EditItem::class, ['record' => $item->id])
            ->fillForm($updatedData)
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('items', [
            'id' => $item->id,
            'category_id' => $newCategory->id,
            'status' => 'fixed',
            'description' => 'Updated description',
            'issue' => 'Updated issue',
        ]);
    });

    test('validates required fields when updating item', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $owner = User::factory()->create(['email_verified_at' => now()]);
        $category = Category::factory()->create();
        $user->givePermissionTo(['access-admin-panel', 'manage-items']);

        $item = Item::factory()->create([
            'user_id' => $owner->id,
            'category_id' => $category->id,
        ]);

        Livewire::actingAs($user)
            ->test(EditItem::class, ['record' => $item->id])
            ->fillForm([
                'user_id' => null,
                'category_id' => null,
                'status' => null,
                'powered' => null,
                'description' => '',
                'issue' => '',
            ])
            ->call('save')
            ->assertHasFormErrors([
                'user_id' => 'required',
                'category_id' => 'required',
                'status' => 'required',
                'powered' => 'required',
                'description' => 'required',
                'issue' => 'required',
            ]);
    });
});

describe('Delete Item', function () {
    test('can soft delete item from list page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $owner = User::factory()->create(['email_verified_at' => now()]);
        $category = Category::factory()->create();
        $user->givePermissionTo(['access-admin-panel', 'manage-items']);

        $item = Item::factory()->create([
            'user_id' => $owner->id,
            'category_id' => $category->id,
        ]);

        Livewire::actingAs($user)
            ->test(ListItems::class)
            ->selectTableRecords([$item->id])
            ->callAction(TestAction::make('delete')->table()->bulk());

        expect($item->fresh()->trashed())->toBeTrue();
    });

    test('can soft delete item from view page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $owner = User::factory()->create(['email_verified_at' => now()]);
        $category = Category::factory()->create();
        $user->givePermissionTo(['access-admin-panel', 'manage-items']);

        $item = Item::factory()->create([
            'user_id' => $owner->id,
            'category_id' => $category->id,
        ]);

        Livewire::actingAs($user)
            ->test(ViewItem::class, ['record' => $item->id])
            ->callAction('delete');

        expect($item->fresh()->trashed())->toBeTrue();
    });

    test('can restore soft deleted item', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $owner = User::factory()->create(['email_verified_at' => now()]);
        $category = Category::factory()->create();
        $user->givePermissionTo(['access-admin-panel', 'manage-items']);

        $item = Item::factory()->create([
            'user_id' => $owner->id,
            'category_id' => $category->id,
        ]);
        $item->delete();

        Livewire::actingAs($user)
            ->test(ListItems::class)
            ->filterTable('trashed', 'only')
            ->selectTableRecords([$item->id])
            ->callAction(TestAction::make('restore')->table()->bulk());

        expect($item->fresh()->trashed())->toBeFalse();
    });

    test('can force delete item', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $owner = User::factory()->create(['email_verified_at' => now()]);
        $category = Category::factory()->create();
        $user->givePermissionTo(['access-admin-panel', 'manage-items']);

        $item = Item::factory()->create([
            'user_id' => $owner->id,
            'category_id' => $category->id,
        ]);
        $item->delete();

        Livewire::actingAs($user)
            ->test(ListItems::class)
            ->filterTable('trashed', 'only')
            ->selectTableRecords([$item->id])
            ->callAction(TestAction::make('forceDelete')->table()->bulk());

        expect(Item::withTrashed()->find($item->id))->toBeNull();
    });
});
