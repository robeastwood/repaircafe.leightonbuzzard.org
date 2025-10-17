<?php

declare(strict_types=1);

use App\Filament\Resources\Users\Pages\ViewUser;
use App\Filament\Resources\Users\RelationManagers\ItemsRelationManager;
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

describe('User Items Relation Manager - Create Action Authorization', function () {
    test('users with manage-items permission can see create action', function () {
        $admin = User::factory()->create(['email_verified_at' => now()]);
        $admin->givePermissionTo(['access-admin-panel', 'manage-items']);

        $targetUser = User::factory()->create(['email_verified_at' => now()]);

        Livewire::actingAs($admin)
            ->test(ItemsRelationManager::class, [
                'ownerRecord' => $targetUser,
                'pageClass' => ViewUser::class,
            ])
            ->assertActionExists(TestAction::make('create')->table());
    });

    test('users without manage-items permission cannot see create action', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo('access-admin-panel');

        $targetUser = User::factory()->create(['email_verified_at' => now()]);

        Livewire::actingAs($user)
            ->test(ItemsRelationManager::class, [
                'ownerRecord' => $targetUser,
                'pageClass' => ViewUser::class,
            ])
            ->assertActionHidden(TestAction::make('create')->table());
    });

    test('users with manage-items permission can create items for other users', function () {
        $admin = User::factory()->create(['email_verified_at' => now()]);
        $admin->givePermissionTo(['access-admin-panel', 'manage-items']);

        $targetUser = User::factory()->create(['email_verified_at' => now()]);
        $category = Category::factory()->create();

        $itemData = [
            'category_id' => $category->id,
            'status' => 'broken',
            'powered' => 'mains',
            'description' => 'Test item for user',
            'issue' => 'Test issue',
        ];

        Livewire::actingAs($admin)
            ->test(ItemsRelationManager::class, [
                'ownerRecord' => $targetUser,
                'pageClass' => ViewUser::class,
            ])
            ->callAction(TestAction::make('create')->table(), $itemData)
            ->assertHasNoErrors();

        $this->assertDatabaseHas('items', [
            'user_id' => $targetUser->id,
            'category_id' => $category->id,
            'status' => 'broken',
            'description' => 'Test item for user',
        ]);
    });

    test('user field is pre-filled and disabled when creating item', function () {
        $admin = User::factory()->create(['email_verified_at' => now()]);
        $admin->givePermissionTo(['access-admin-panel', 'manage-items']);

        $targetUser = User::factory()->create(['email_verified_at' => now()]);

        Livewire::actingAs($admin)
            ->test(ItemsRelationManager::class, [
                'ownerRecord' => $targetUser,
                'pageClass' => ViewUser::class,
            ])
            ->mountAction(TestAction::make('create')->table())
            ->assertSchemaStateSet([
                'user_id' => $targetUser->id,
            ]);
    });

    test('created item automatically belongs to the target user', function () {
        $admin = User::factory()->create(['email_verified_at' => now()]);
        $admin->givePermissionTo(['access-admin-panel', 'manage-items']);

        $targetUser = User::factory()->create(['email_verified_at' => now()]);
        $category = Category::factory()->create();

        $itemData = [
            'category_id' => $category->id,
            'status' => 'broken',
            'powered' => 'mains',
            'description' => 'Auto-assigned item',
            'issue' => 'Auto-assigned issue',
        ];

        Livewire::actingAs($admin)
            ->test(ItemsRelationManager::class, [
                'ownerRecord' => $targetUser,
                'pageClass' => ViewUser::class,
            ])
            ->callAction(TestAction::make('create')->table(), $itemData);

        $item = Item::where('description', 'Auto-assigned item')->first();
        expect($item)->not->toBeNull();
        expect($item->user_id)->toBe($targetUser->id);
    });
});

describe('User Items Relation Manager - Display', function () {
    test('displays items belonging to user', function () {
        $admin = User::factory()->create(['email_verified_at' => now()]);
        $admin->givePermissionTo(['access-admin-panel', 'manage-items']);

        $targetUser = User::factory()->create(['email_verified_at' => now()]);
        $otherUser = User::factory()->create(['email_verified_at' => now()]);
        $category = Category::factory()->create();

        $userItems = Item::factory()->count(3)->create([
            'user_id' => $targetUser->id,
            'category_id' => $category->id,
        ]);

        $otherUserItem = Item::factory()->create([
            'user_id' => $otherUser->id,
            'category_id' => $category->id,
        ]);

        Livewire::actingAs($admin)
            ->test(ItemsRelationManager::class, [
                'ownerRecord' => $targetUser,
                'pageClass' => ViewUser::class,
            ])
            ->assertCanSeeTableRecords($userItems)
            ->assertCanNotSeeTableRecords([$otherUserItem]);
    });

    test('displays item details correctly', function () {
        $admin = User::factory()->create(['email_verified_at' => now()]);
        $admin->givePermissionTo('access-admin-panel');

        $targetUser = User::factory()->create(['email_verified_at' => now()]);
        $category = Category::factory()->create(['name' => 'Electronics']);

        $item = Item::factory()->create([
            'user_id' => $targetUser->id,
            'category_id' => $category->id,
            'description' => 'Broken Laptop',
            'status' => 'broken',
        ]);

        Livewire::actingAs($admin)
            ->test(ItemsRelationManager::class, [
                'ownerRecord' => $targetUser,
                'pageClass' => ViewUser::class,
            ])
            ->assertCanSeeTableRecords([$item])
            ->assertSee('Broken Laptop')
            ->assertSee('Electronics');
    });
});
