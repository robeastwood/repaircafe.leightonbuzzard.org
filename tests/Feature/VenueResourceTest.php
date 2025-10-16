<?php

declare(strict_types=1);

use App\Filament\Resources\Venues\Pages\CreateVenue;
use App\Filament\Resources\Venues\Pages\EditVenue;
use App\Filament\Resources\Venues\Pages\ListVenues;
use App\Models\Event;
use App\Models\User;
use App\Models\Venue;
use Filament\Actions\Testing\TestAction;
use Filament\Facades\Filament;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;

use function Pest\Laravel\assertDatabaseHas;

beforeEach(function () {
    Filament::setCurrentPanel('admin');
    Permission::firstOrCreate(['name' => 'access-admin-panel', 'guard_name' => 'web']);
    Permission::firstOrCreate(['name' => 'manage-venues', 'guard_name' => 'web']);
});

describe('Venue Resource Authorization', function () {
    test('users with manage-venues permission can see venues in navigation', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-venues']);

        $this->actingAs($user);

        expect(\App\Filament\Resources\Venues\VenueResource::canViewAny())->toBeTrue();
    });

    test('users without manage-venues permission cannot see venues in navigation', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo('access-admin-panel');

        $this->actingAs($user);

        expect(\App\Filament\Resources\Venues\VenueResource::canViewAny())->toBeFalse();
    });

    test('guest users cannot see venues in navigation', function () {
        expect(\App\Filament\Resources\Venues\VenueResource::canViewAny())->toBeFalse();
    });

    test('users without manage-venues permission cannot access list page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo('access-admin-panel');

        Livewire::actingAs($user)
            ->test(ListVenues::class)
            ->assertForbidden();
    });

    test('users without manage-venues permission cannot access create page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo('access-admin-panel');

        Livewire::actingAs($user)
            ->test(CreateVenue::class)
            ->assertForbidden();
    });

    test('users without manage-venues permission cannot access edit page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo('access-admin-panel');

        $venue = Venue::factory()->create();

        Livewire::actingAs($user)
            ->test(EditVenue::class, ['record' => $venue->id])
            ->assertForbidden();
    });
});

describe('List Venues', function () {
    test('can render list venues page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-venues']);

        Livewire::actingAs($user)
            ->test(ListVenues::class)
            ->assertSuccessful();
    });

    test('can list venues', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-venues']);

        $venues = Venue::factory()->count(3)->create();

        Livewire::actingAs($user)
            ->test(ListVenues::class)
            ->assertCanSeeTableRecords($venues);
    });

    test('can search venues by name', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-venues']);

        $venues = [
            Venue::factory()->create(['name' => 'Community Hall', 'description' => 'A large hall']),
            Venue::factory()->create(['name' => 'City Center', 'description' => 'Downtown location']),
            Venue::factory()->create(['name' => 'Garden Space', 'description' => 'Outdoor venue']),
        ];

        Livewire::actingAs($user)
            ->test(ListVenues::class)
            ->searchTable('Community')
            ->assertCanSeeTableRecords([$venues[0]])
            ->assertCanNotSeeTableRecords([$venues[1], $venues[2]]);
    });

    test('trashed filter exists', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-venues']);

        Livewire::actingAs($user)
            ->test(ListVenues::class)
            ->assertTableFilterExists('trashed');
    })->todo('Full trashed filter testing requires investigation - filter not applying correctly in tests despite deferFilters(false)');
});

describe('Create Venue', function () {
    test('can render create venue page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-venues']);

        Livewire::actingAs($user)
            ->test(CreateVenue::class)
            ->assertSuccessful();
    });

    test('can create venue', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-venues']);

        $newVenue = [
            'name' => 'New Community Center',
            'description' => 'A wonderful place for events',
        ];

        Livewire::actingAs($user)
            ->test(CreateVenue::class)
            ->fillForm($newVenue)
            ->call('create')
            ->assertHasNoFormErrors();

        assertDatabaseHas(Venue::class, $newVenue);
    });

    test('can validate required fields when creating venue', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-venues']);

        Livewire::actingAs($user)
            ->test(CreateVenue::class)
            ->fillForm([
                'name' => '',
                'description' => '',
            ])
            ->call('create')
            ->assertHasFormErrors(['name' => 'required', 'description' => 'required']);
    });
});

describe('Edit Venue', function () {
    test('can render edit venue page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-venues']);

        $venue = Venue::factory()->create([
            'name' => 'Test Venue',
            'description' => 'Test Description',
        ]);

        Livewire::actingAs($user)
            ->test(EditVenue::class, ['record' => $venue->id])
            ->assertSuccessful();
    });

    test('can retrieve venue data in edit form', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-venues']);

        $venue = Venue::factory()->create([
            'name' => 'Original Name',
            'description' => 'Original Description',
        ]);

        Livewire::actingAs($user)
            ->test(EditVenue::class, ['record' => $venue->id])
            ->assertSchemaStateSet([
                'name' => 'Original Name',
                'description' => 'Original Description',
            ]);
    });

    test('can update venue', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-venues']);

        $venue = Venue::factory()->create([
            'name' => 'Old Name',
            'description' => 'Old Description',
        ]);

        $updatedData = [
            'name' => 'Updated Name',
            'description' => 'Updated Description',
        ];

        Livewire::actingAs($user)
            ->test(EditVenue::class, ['record' => $venue->id])
            ->fillForm($updatedData)
            ->call('save')
            ->assertHasNoFormErrors();

        assertDatabaseHas(Venue::class, $updatedData);
    });

    test('can validate required fields when updating venue', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-venues']);

        $venue = Venue::factory()->create([
            'name' => 'Test Venue',
            'description' => 'Test Description',
        ]);

        Livewire::actingAs($user)
            ->test(EditVenue::class, ['record' => $venue->id])
            ->fillForm([
                'name' => '',
                'description' => '',
            ])
            ->call('save')
            ->assertHasFormErrors(['name' => 'required', 'description' => 'required']);
    });
});

describe('Delete Venue', function () {
    test('can soft delete venue from list page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-venues']);

        $venue = Venue::factory()->create([
            'name' => 'Venue to Delete',
            'description' => 'Will be deleted',
        ]);

        Livewire::actingAs($user)
            ->test(ListVenues::class)
            ->selectTableRecords([$venue->id])
            ->callAction(TestAction::make('delete')->table()->bulk());

        expect($venue->fresh()->trashed())->toBeTrue();
    });

    test('can restore soft deleted venue', function () {
        Permission::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']);

        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-venues', 'super-admin']);

        $venue = Venue::factory()->create([
            'name' => 'Deleted Venue',
            'description' => 'Was deleted',
        ]);
        $venue->delete();

        Livewire::actingAs($user)
            ->test(ListVenues::class)
            ->filterTable('trashed', 'only')
            ->selectTableRecords([$venue->id])
            ->callAction(TestAction::make('restore')->table()->bulk());

        expect($venue->fresh()->trashed())->toBeFalse();
    });

    test('can force delete venue', function () {
        Permission::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']);

        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-venues', 'super-admin']);

        $venue = Venue::factory()->create([
            'name' => 'Venue to Force Delete',
            'description' => 'Will be permanently deleted',
        ]);
        $venue->delete();

        Livewire::actingAs($user)
            ->test(ListVenues::class)
            ->filterTable('trashed', 'only')
            ->selectTableRecords([$venue->id])
            ->callAction(TestAction::make('forceDelete')->table()->bulk());

        expect(Venue::withTrashed()->find($venue->id))->toBeNull();
    });
});

describe('Venue Relationships', function () {
    test('soft deleting venue preserves associated events', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-venues']);

        $venue = Venue::factory()->create();
        $event = Event::factory()->create(['venue_id' => $venue->id]);

        $venue->delete();

        expect($venue->fresh()->trashed())->toBeTrue();
        expect($event->fresh())->not->toBeNull();
        expect($event->venue_id)->toBe($venue->id);
    });

    test('venue can have multiple events', function () {
        $venue = Venue::factory()->create();
        $events = Event::factory()->count(3)->create(['venue_id' => $venue->id]);

        expect($venue->events)->toHaveCount(3);
        expect($venue->events->pluck('id'))->toEqual($events->pluck('id'));
    });
});

describe('Validation Edge Cases', function () {
    test('validates name field with various invalid inputs', function (mixed $invalidName, string $expectedError) {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-venues']);

        Livewire::actingAs($user)
            ->test(CreateVenue::class)
            ->fillForm([
                'name' => $invalidName,
                'description' => 'Valid description',
            ])
            ->call('create')
            ->assertHasFormErrors(['name' => $expectedError]);
    })->with([
        'empty string' => ['', 'required'],
        'null value' => [null, 'required'],
    ]);

    test('validates description field with various invalid inputs', function (mixed $invalidDescription, string $expectedError) {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-venues']);

        Livewire::actingAs($user)
            ->test(CreateVenue::class)
            ->fillForm([
                'name' => 'Valid Name',
                'description' => $invalidDescription,
            ])
            ->call('create')
            ->assertHasFormErrors(['description' => $expectedError]);
    })->with([
        'empty string' => ['', 'required'],
        'null value' => [null, 'required'],
    ]);

    test('accepts valid venue with special characters', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-venues']);

        $venueData = [
            'name' => "St. Mary's Community Center & Hall",
            'description' => 'A venue with special characters: @, #, $, %, &, *',
        ];

        Livewire::actingAs($user)
            ->test(CreateVenue::class)
            ->fillForm($venueData)
            ->call('create')
            ->assertHasNoFormErrors();

        assertDatabaseHas(Venue::class, $venueData);
    });
});
