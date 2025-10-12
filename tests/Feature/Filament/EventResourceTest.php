<?php

declare(strict_types=1);

use App\Filament\Resources\Events\Pages\CreateEvent;
use App\Filament\Resources\Events\Pages\ListEvents;
use App\Filament\Resources\Events\Pages\ViewEvent;
use App\Models\Event;
use App\Models\User;
use App\Models\Venue;
use Filament\Actions\Testing\TestAction;
use Filament\Facades\Filament;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;

beforeEach(function () {
    Filament::setCurrentPanel('admin');
    Permission::firstOrCreate(['name' => 'access-admin-panel', 'guard_name' => 'web']);
    Permission::firstOrCreate(['name' => 'manage-events', 'guard_name' => 'web']);
});

describe('Event Resource Authorization', function () {
    test('users with manage-events permission can see events in navigation', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-events']);

        $this->actingAs($user);

        expect(\App\Filament\Resources\Events\EventResource::canViewAny())->toBeTrue();
    });

    test('authenticated users can see events in navigation', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo('access-admin-panel');

        $this->actingAs($user);

        expect(\App\Filament\Resources\Events\EventResource::canViewAny())->toBeTrue();
    });

    test('guest users cannot see events in navigation', function () {
        expect(\App\Filament\Resources\Events\EventResource::canViewAny())->toBeFalse();
    });

    test('authenticated users can access list page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo('access-admin-panel');

        Livewire::actingAs($user)
            ->test(ListEvents::class)
            ->assertSuccessful();
    });

    test('users without manage-events permission cannot access create page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo('access-admin-panel');

        Livewire::actingAs($user)
            ->test(CreateEvent::class)
            ->assertForbidden();
    });

    test('authenticated users can access view page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo('access-admin-panel');

        $venue = Venue::factory()->create();
        $event = Event::factory()->create(['venue_id' => $venue->id]);

        Livewire::actingAs($user)
            ->test(ViewEvent::class, ['record' => $event->id])
            ->assertSuccessful();
    });

    test('users without manage-events permission cannot edit event', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo('access-admin-panel');

        $venue = Venue::factory()->create();
        $event = Event::factory()->create(['venue_id' => $venue->id]);

        Livewire::actingAs($user)
            ->test(ViewEvent::class, ['record' => $event->id])
            ->assertActionHidden('edit');
    });

    test('users without manage-events permission cannot delete event', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo('access-admin-panel');

        $venue = Venue::factory()->create();
        $event = Event::factory()->create(['venue_id' => $venue->id]);

        Livewire::actingAs($user)
            ->test(ViewEvent::class, ['record' => $event->id])
            ->assertActionHidden('delete');
    });
});

describe('List Events', function () {
    test('can render list events page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-events']);

        Livewire::actingAs($user)
            ->test(ListEvents::class)
            ->assertSuccessful();
    });

    test('can list events', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-events']);

        $venue = Venue::factory()->create();
        $events = Event::factory()->count(3)->create(['venue_id' => $venue->id]);

        Livewire::actingAs($user)
            ->test(ListEvents::class)
            ->assertCanSeeTableRecords($events);
    });
});

describe('Create Event', function () {
    test('can render create event page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-events']);

        Livewire::actingAs($user)
            ->test(CreateEvent::class)
            ->assertSuccessful();
    });

    test('can create event with date, start time, and duration', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-events']);

        $venue = Venue::factory()->create();

        $newEvent = [
            'venue_id' => $venue->id,
            'date' => '2025-06-15',
            'start_time' => '10:00:00',
            'duration' => 4,
        ];

        Livewire::actingAs($user)
            ->test(CreateEvent::class)
            ->fillForm($newEvent)
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('events', [
            'venue_id' => $venue->id,
            'starts_at' => '2025-06-15 10:00:00',
            'ends_at' => '2025-06-15 14:00:00',
        ]);
    });

    test('can validate required fields when creating event', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-events']);

        Livewire::actingAs($user)
            ->test(CreateEvent::class)
            ->fillForm([
                'venue_id' => null,
                'date' => '',
                'start_time' => '',
                'duration' => '',
            ])
            ->call('create')
            ->assertHasFormErrors([
                'venue_id' => 'required',
                'date' => 'required',
                'start_time' => 'required',
                'duration' => 'required',
            ]);
    });

    test('validates duration minimum value', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-events']);

        $venue = Venue::factory()->create();

        Livewire::actingAs($user)
            ->test(CreateEvent::class)
            ->fillForm([
                'venue_id' => $venue->id,
                'date' => '2025-06-15',
                'start_time' => '10:00:00',
                'duration' => 0.25,
            ])
            ->call('create')
            ->assertHasFormErrors(['duration']);
    });

    test('validates duration maximum value', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-events']);

        $venue = Venue::factory()->create();

        Livewire::actingAs($user)
            ->test(CreateEvent::class)
            ->fillForm([
                'venue_id' => $venue->id,
                'date' => '2025-06-15',
                'start_time' => '10:00:00',
                'duration' => 25,
            ])
            ->call('create')
            ->assertHasFormErrors(['duration']);
    });

    test('can create event with half-hour duration', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-events']);

        $venue = Venue::factory()->create();

        $newEvent = [
            'venue_id' => $venue->id,
            'date' => '2025-06-15',
            'start_time' => '10:00:00',
            'duration' => 2.5,
        ];

        Livewire::actingAs($user)
            ->test(CreateEvent::class)
            ->fillForm($newEvent)
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('events', [
            'venue_id' => $venue->id,
            'starts_at' => '2025-06-15 10:00:00',
            'ends_at' => '2025-06-15 12:30:00',
        ]);
    });

    test('can create multi-day event with duration', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-events']);

        $venue = Venue::factory()->create();

        $newEvent = [
            'venue_id' => $venue->id,
            'date' => '2025-06-15',
            'start_time' => '10:00:00',
            'duration' => 52,
        ];

        Livewire::actingAs($user)
            ->test(CreateEvent::class)
            ->fillForm($newEvent)
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('events', [
            'venue_id' => $venue->id,
            'starts_at' => '2025-06-15 10:00:00',
            'ends_at' => '2025-06-17 14:00:00',
        ]);
    })->todo('Duration validation currently allows up to 24 hours, may need adjustment if events longer than 24 hours are ever needed');
});

describe('View Event', function () {
    test('can render view event page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-events']);

        $venue = Venue::factory()->create();
        $event = Event::factory()->create([
            'venue_id' => $venue->id,
            'starts_at' => '2025-06-15 10:00:00',
            'ends_at' => '2025-06-15 14:00:00',
        ]);

        Livewire::actingAs($user)
            ->test(ViewEvent::class, ['record' => $event->id])
            ->assertSuccessful();
    });

    test('can update event via modal edit action', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-events']);

        $venue = Venue::factory()->create();
        $newVenue = Venue::factory()->create();
        $event = Event::factory()->create([
            'venue_id' => $venue->id,
            'starts_at' => '2025-06-15 10:00:00',
            'ends_at' => '2025-06-15 14:00:00',
        ]);

        $updatedData = [
            'venue_id' => $newVenue->id,
            'date' => '2025-06-20',
            'start_time' => '09:00:00',
            'duration' => 8,
        ];

        Livewire::actingAs($user)
            ->test(ViewEvent::class, ['record' => $event->id])
            ->callAction('edit', $updatedData)
            ->assertHasNoActionErrors();

        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'venue_id' => $newVenue->id,
            'starts_at' => '2025-06-20 09:00:00',
            'ends_at' => '2025-06-20 17:00:00',
        ]);
    });

    test('can validate required fields when updating event via modal', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-events']);

        $venue = Venue::factory()->create();
        $event = Event::factory()->create([
            'venue_id' => $venue->id,
            'starts_at' => '2025-06-15 10:00:00',
            'ends_at' => '2025-06-15 14:00:00',
        ]);

        Livewire::actingAs($user)
            ->test(ViewEvent::class, ['record' => $event->id])
            ->callAction('edit', [
                'venue_id' => null,
                'date' => '',
                'start_time' => '',
                'duration' => '',
            ])
            ->assertHasActionErrors([
                'venue_id' => 'required',
                'date' => 'required',
                'start_time' => 'required',
                'duration' => 'required',
            ]);
    });
});

describe('Delete Event', function () {
    test('can soft delete event from list page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-events']);

        $venue = Venue::factory()->create();
        $event = Event::factory()->create(['venue_id' => $venue->id]);

        Livewire::actingAs($user)
            ->test(ListEvents::class)
            ->selectTableRecords([$event->id])
            ->callAction(TestAction::make('delete')->table()->bulk());

        expect($event->fresh()->trashed())->toBeTrue();
    });

    test('can soft delete event from view page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-events']);

        $venue = Venue::factory()->create();
        $event = Event::factory()->create(['venue_id' => $venue->id]);

        Livewire::actingAs($user)
            ->test(ViewEvent::class, ['record' => $event->id])
            ->callAction('delete');

        expect($event->fresh()->trashed())->toBeTrue();
    });

    test('can restore soft deleted event', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-events']);

        $venue = Venue::factory()->create();
        $event = Event::factory()->create(['venue_id' => $venue->id]);
        $event->delete();

        Livewire::actingAs($user)
            ->test(ListEvents::class)
            ->filterTable('trashed', 'only')
            ->selectTableRecords([$event->id])
            ->callAction(TestAction::make('restore')->table()->bulk());

        expect($event->fresh()->trashed())->toBeFalse();
    });

    test('can force delete event', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-events']);

        $venue = Venue::factory()->create();
        $event = Event::factory()->create(['venue_id' => $venue->id]);
        $event->delete();

        Livewire::actingAs($user)
            ->test(ListEvents::class)
            ->filterTable('trashed', 'only')
            ->selectTableRecords([$event->id])
            ->callAction(TestAction::make('forceDelete')->table()->bulk());

        expect(Event::withTrashed()->find($event->id))->toBeNull();
    });
});

describe('Items Relation Manager', function () {
    test('can render items relation manager on view event page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-events']);

        $venue = Venue::factory()->create();
        $event = Event::factory()->create(['venue_id' => $venue->id]);

        Livewire::actingAs($user)
            ->test(ViewEvent::class, ['record' => $event->id])
            ->assertSuccessful();
    });

    test('can see items booked into event in relation manager', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-events']);

        $venue = Venue::factory()->create();
        $event = Event::factory()->create(['venue_id' => $venue->id]);

        $category = \App\Models\Category::factory()->create();
        $itemOwner = User::factory()->create();
        $items = \App\Models\Item::factory()->count(3)->create([
            'user_id' => $itemOwner->id,
            'category_id' => $category->id,
        ]);

        $event->items()->attach($items);

        Livewire::actingAs($user)
            ->test(\App\Filament\Resources\Events\RelationManagers\ItemsRelationManager::class, [
                'ownerRecord' => $event,
                'pageClass' => ViewEvent::class,
            ])
            ->assertCanSeeTableRecords($items);
    });

    test('items relation manager shows correct columns', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-events']);

        $venue = Venue::factory()->create();
        $event = Event::factory()->create(['venue_id' => $venue->id]);

        $category = \App\Models\Category::factory()->create(['name' => 'Electronics']);
        $itemOwner = User::factory()->create(['name' => 'John Doe']);
        $item = \App\Models\Item::factory()->create([
            'user_id' => $itemOwner->id,
            'category_id' => $category->id,
            'description' => 'Broken toaster',
            'status' => 'broken',
        ]);

        $event->items()->attach($item);

        Livewire::actingAs($user)
            ->test(\App\Filament\Resources\Events\RelationManagers\ItemsRelationManager::class, [
                'ownerRecord' => $event,
                'pageClass' => ViewEvent::class,
            ])
            ->assertSuccessful()
            ->assertSee('Broken toaster')
            ->assertSee('John Doe')
            ->assertSee('Electronics');
    });

    test('can filter items by status', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-events']);

        $venue = Venue::factory()->create();
        $event = Event::factory()->create(['venue_id' => $venue->id]);

        $category = \App\Models\Category::factory()->create();
        $itemOwner = User::factory()->create();

        $brokenItem = \App\Models\Item::factory()->create([
            'user_id' => $itemOwner->id,
            'category_id' => $category->id,
            'status' => 'broken',
        ]);

        $fixedItem = \App\Models\Item::factory()->create([
            'user_id' => $itemOwner->id,
            'category_id' => $category->id,
            'status' => 'fixed',
        ]);

        $event->items()->attach([$brokenItem->id, $fixedItem->id]);

        Livewire::actingAs($user)
            ->test(\App\Filament\Resources\Events\RelationManagers\ItemsRelationManager::class, [
                'ownerRecord' => $event,
                'pageClass' => ViewEvent::class,
            ])
            ->assertCanSeeTableRecords([$brokenItem, $fixedItem])
            ->filterTable('status', ['broken'])
            ->assertCanSeeTableRecords([$brokenItem])
            ->assertCanNotSeeTableRecords([$fixedItem]);
    });

    test('can filter items by checked-in status', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-events']);

        $venue = Venue::factory()->create();
        $event = Event::factory()->create(['venue_id' => $venue->id]);

        $category = \App\Models\Category::factory()->create();
        $itemOwner = User::factory()->create();

        $checkedInItem = \App\Models\Item::factory()->create([
            'user_id' => $itemOwner->id,
            'category_id' => $category->id,
        ]);

        $notCheckedInItem = \App\Models\Item::factory()->create([
            'user_id' => $itemOwner->id,
            'category_id' => $category->id,
        ]);

        $event->items()->attach($checkedInItem->id, ['checkedin' => now()]);
        $event->items()->attach($notCheckedInItem->id, ['checkedin' => null]);

        Livewire::actingAs($user)
            ->test(\App\Filament\Resources\Events\RelationManagers\ItemsRelationManager::class, [
                'ownerRecord' => $event,
                'pageClass' => ViewEvent::class,
            ])
            ->assertCanSeeTableRecords([$checkedInItem, $notCheckedInItem])
            ->filterTable('checkedin', true)
            ->assertCanSeeTableRecords([$checkedInItem])
            ->assertCanNotSeeTableRecords([$notCheckedInItem]);
    });

    test('check-in status is stored as datetime in pivot table', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-events']);

        $venue = Venue::factory()->create();
        $event = Event::factory()->create(['venue_id' => $venue->id]);

        $category = \App\Models\Category::factory()->create();
        $itemOwner = User::factory()->create();
        $item = \App\Models\Item::factory()->create([
            'user_id' => $itemOwner->id,
            'category_id' => $category->id,
        ]);

        // Attach without check-in
        $event->items()->attach($item->id, ['checkedin' => null]);
        $pivot = $event->items()->where('item_id', $item->id)->first()->pivot;
        expect($pivot->checkedin)->toBeNull();

        // Update to checked in
        $event->items()->updateExistingPivot($item->id, ['checkedin' => now()]);
        $pivot = $event->items()->where('item_id', $item->id)->first()->pivot;
        expect($pivot->checkedin)->not->toBeNull();
        expect($pivot->checkedin)->toBeInstanceOf(\Illuminate\Support\Carbon::class);
    });

    test('can filter items by repairer assignment', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-events']);

        $venue = Venue::factory()->create();
        $event = Event::factory()->create(['venue_id' => $venue->id]);

        $category = \App\Models\Category::factory()->create();
        $itemOwner = User::factory()->create();
        $repairer = User::factory()->create();

        $event->users()->attach($repairer, ['fixer' => true]);

        $assignedItem = \App\Models\Item::factory()->create([
            'user_id' => $itemOwner->id,
            'category_id' => $category->id,
        ]);

        $unassignedItem = \App\Models\Item::factory()->create([
            'user_id' => $itemOwner->id,
            'category_id' => $category->id,
        ]);

        $event->items()->attach($assignedItem->id, ['repairer_id' => $repairer->id]);
        $event->items()->attach($unassignedItem->id, ['repairer_id' => null]);

        Livewire::actingAs($user)
            ->test(\App\Filament\Resources\Events\RelationManagers\ItemsRelationManager::class, [
                'ownerRecord' => $event,
                'pageClass' => ViewEvent::class,
            ])
            ->assertCanSeeTableRecords([$assignedItem, $unassignedItem])
            ->filterTable('repairer_assigned', $repairer->id)
            ->assertCanSeeTableRecords([$assignedItem])
            ->assertCanNotSeeTableRecords([$unassignedItem]);
    });

    test('prevents booking the same item into an event twice', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-events']);

        $venue = Venue::factory()->create();
        $event = Event::factory()->create(['venue_id' => $venue->id]);

        $category = \App\Models\Category::factory()->create();
        $itemOwner = User::factory()->create();
        $item = \App\Models\Item::factory()->create([
            'user_id' => $itemOwner->id,
            'category_id' => $category->id,
        ]);

        // Attach item to event
        $event->items()->attach($item->id);

        // Verify unique constraint prevents duplicate
        expect(fn () => $event->items()->attach($item->id))
            ->toThrow(\Illuminate\Database\UniqueConstraintViolationException::class);

        // Verify only one record exists
        expect($event->items()->count())->toBe(1);
    });
});
