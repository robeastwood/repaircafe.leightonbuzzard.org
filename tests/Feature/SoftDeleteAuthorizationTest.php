<?php

declare(strict_types=1);

use App\Models\Category;
use App\Models\Event;
use App\Models\Item;
use App\Models\User;
use App\Models\Venue;
use Spatie\Permission\Models\Permission;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    Permission::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']);
    Permission::firstOrCreate(['name' => 'manage-items', 'guard_name' => 'web']);
    Permission::firstOrCreate(['name' => 'manage-events', 'guard_name' => 'web']);
    Permission::firstOrCreate(['name' => 'manage-categories', 'guard_name' => 'web']);
    Permission::firstOrCreate(['name' => 'manage-venues', 'guard_name' => 'web']);
});

describe('Item Soft Delete Authorization', function () {
    test('non-super-admin cannot see soft-deleted items in query', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo('manage-items');
        $category = Category::factory()->create();

        $activeItem = Item::create(['user_id' => $user->id, 'category_id' => $category->id, 'status' => 'broken', 'description' => 'Test', 'issue' => 'Test', 'powered' => 'no']);
        $deletedItem = Item::create(['user_id' => $user->id, 'category_id' => $category->id, 'status' => 'broken', 'description' => 'Test 2', 'issue' => 'Test 2', 'powered' => 'no']);
        $deletedItem->delete(); // Soft delete it

        actingAs($user);

        $items = Item::all();

        expect($items)->toHaveCount(1);
        expect($items->first()->id)->toBe($activeItem->id);
    });

    test('super-admin cannot see soft-deleted items in regular query', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['manage-items', 'super-admin']);
        $category = Category::factory()->create();

        $activeItem = Item::create(['user_id' => $user->id, 'category_id' => $category->id, 'status' => 'broken', 'description' => 'Test', 'issue' => 'Test', 'powered' => 'no']);
        $deletedItem = Item::create(['user_id' => $user->id, 'category_id' => $category->id, 'status' => 'broken', 'description' => 'Test 2', 'issue' => 'Test 2', 'powered' => 'no']);
        $deletedItem->delete(); // Soft delete it

        actingAs($user);

        $items = Item::all();

        // Super-admins also don't see soft-deleted items in lists
        expect($items)->toHaveCount(1);
        expect($items->first()->id)->toBe($activeItem->id);
    });

    test('super-admin can access soft-deleted item directly', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['manage-items', 'super-admin']);
        $category = Category::factory()->create();

        $deletedItem = Item::create(['user_id' => $user->id, 'category_id' => $category->id, 'status' => 'broken', 'description' => 'Test', 'issue' => 'Test', 'powered' => 'no']);
        $deletedItem->delete(); // Soft delete it

        actingAs($user);

        $foundItem = Item::withTrashed()->find($deletedItem->id);

        expect($foundItem)->not->toBeNull();
        expect($foundItem->id)->toBe($deletedItem->id);
    });

    test('non-super-admin cannot view soft-deleted item', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo('manage-items');
        $category = Category::factory()->create();

        $deletedItem = Item::create(['user_id' => $user->id, 'category_id' => $category->id, 'status' => 'broken', 'description' => 'Test', 'issue' => 'Test', 'powered' => 'no']);
        $deletedItem->delete(); // Soft delete it
        $deletedItem->refresh(); // Refresh to get the deleted_at timestamp

        actingAs($user);

        $authorized = $user->can('view', $deletedItem);

        expect($authorized)->toBeFalse();
    });

    test('super-admin can view soft-deleted item', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['manage-items', 'super-admin']);
        $category = Category::factory()->create();

        $deletedItem = Item::create(['user_id' => $user->id, 'category_id' => $category->id, 'status' => 'broken', 'description' => 'Test', 'issue' => 'Test', 'powered' => 'no']);
        $deletedItem->delete(); // Soft delete it
        $deletedItem->refresh(); // Refresh to get the deleted_at timestamp

        actingAs($user);

        $authorized = $user->can('view', $deletedItem);

        expect($authorized)->toBeTrue();
    });

    test('non-super-admin cannot restore soft-deleted item', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo('manage-items');
        $category = Category::factory()->create();

        $deletedItem = Item::create(['user_id' => $user->id, 'category_id' => $category->id, 'status' => 'broken', 'description' => 'Test', 'issue' => 'Test', 'powered' => 'no']);
        $deletedItem->delete(); // Soft delete it
        $deletedItem->refresh(); // Refresh to get the deleted_at timestamp

        actingAs($user);

        $authorized = $user->can('restore', $deletedItem);

        expect($authorized)->toBeFalse();
    });

    test('super-admin can restore soft-deleted item', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['manage-items', 'super-admin']);
        $category = Category::factory()->create();

        $deletedItem = Item::create(['user_id' => $user->id, 'category_id' => $category->id, 'status' => 'broken', 'description' => 'Test', 'issue' => 'Test', 'powered' => 'no']);
        $deletedItem->delete(); // Soft delete it
        $deletedItem->refresh(); // Refresh to get the deleted_at timestamp

        actingAs($user);

        $authorized = $user->can('restore', $deletedItem);

        expect($authorized)->toBeTrue();
    });

    test('non-super-admin cannot force delete item', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo('manage-items');
        $category = Category::factory()->create();

        $item = Item::create(['user_id' => $user->id, 'category_id' => $category->id, 'status' => 'broken', 'description' => 'Test', 'issue' => 'Test', 'powered' => 'no']);

        actingAs($user);

        $authorized = $user->can('forceDelete', $item);

        expect($authorized)->toBeFalse();
    });

    test('super-admin can force delete item', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['manage-items', 'super-admin']);
        $category = Category::factory()->create();

        $item = Item::create(['user_id' => $user->id, 'category_id' => $category->id, 'status' => 'broken', 'description' => 'Test', 'issue' => 'Test', 'powered' => 'no']);

        actingAs($user);

        $authorized = $user->can('forceDelete', $item);

        expect($authorized)->toBeTrue();
    });
});

describe('Event Soft Delete Authorization', function () {
    test('non-super-admin cannot see soft-deleted events in query', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo('manage-events');

        $venue = Venue::factory()->create();
        $activeEvent = Event::factory()->create(['venue_id' => $venue->id]);
        $deletedEvent = Event::factory()->create(['venue_id' => $venue->id, 'deleted_at' => now()]);

        actingAs($user);

        $events = Event::all();

        expect($events)->toHaveCount(1);
        expect($events->contains($activeEvent))->toBeTrue();
        expect($events->contains($deletedEvent))->toBeFalse();
    });

    test('non-super-admin cannot view soft-deleted event', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo('manage-events');

        $venue = Venue::factory()->create();
        $deletedEvent = Event::factory()->create(['venue_id' => $venue->id, 'deleted_at' => now()]);

        actingAs($user);

        $authorized = $user->can('view', $deletedEvent);

        expect($authorized)->toBeFalse();
    });

    test('super-admin can view soft-deleted event', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['manage-events', 'super-admin']);

        $venue = Venue::factory()->create();
        $deletedEvent = Event::factory()->create(['venue_id' => $venue->id, 'deleted_at' => now()]);

        actingAs($user);

        $authorized = $user->can('view', $deletedEvent);

        expect($authorized)->toBeTrue();
    });
});

describe('Category Soft Delete Authorization', function () {
    test('non-super-admin cannot see soft-deleted categories in query', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo('manage-categories');

        $activeCategory = Category::factory()->create();
        $deletedCategory = Category::factory()->create(['deleted_at' => now()]);

        actingAs($user);

        $categories = Category::all();

        expect($categories)->toHaveCount(1);
        expect($categories->contains($activeCategory))->toBeTrue();
        expect($categories->contains($deletedCategory))->toBeFalse();
    });

    test('non-super-admin cannot view soft-deleted category', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo('manage-categories');

        $deletedCategory = Category::factory()->create(['deleted_at' => now()]);

        actingAs($user);

        $authorized = $user->can('view', $deletedCategory);

        expect($authorized)->toBeFalse();
    });

    test('super-admin can view soft-deleted category', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['manage-categories', 'super-admin']);

        $deletedCategory = Category::factory()->create(['deleted_at' => now()]);

        actingAs($user);

        $authorized = $user->can('view', $deletedCategory);

        expect($authorized)->toBeTrue();
    });
});

describe('Venue Soft Delete Authorization', function () {
    test('non-super-admin cannot see soft-deleted venues in query', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo('manage-venues');

        $activeVenue = Venue::factory()->create();
        $deletedVenue = Venue::factory()->create(['deleted_at' => now()]);

        actingAs($user);

        $venues = Venue::all();

        expect($venues)->toHaveCount(1);
        expect($venues->contains($activeVenue))->toBeTrue();
        expect($venues->contains($deletedVenue))->toBeFalse();
    });

    test('non-super-admin cannot view soft-deleted venue', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo('manage-venues');

        $deletedVenue = Venue::factory()->create(['deleted_at' => now()]);

        actingAs($user);

        $authorized = $user->can('view', $deletedVenue);

        expect($authorized)->toBeFalse();
    });

    test('super-admin can view soft-deleted venue', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['manage-venues', 'super-admin']);

        $deletedVenue = Venue::factory()->create(['deleted_at' => now()]);

        actingAs($user);

        $authorized = $user->can('view', $deletedVenue);

        expect($authorized)->toBeTrue();
    });
});
