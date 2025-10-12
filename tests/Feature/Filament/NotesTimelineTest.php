<?php

declare(strict_types=1);

use App\Filament\Resources\Items\Pages\ViewItem;
use App\Livewire\Items\NotesTimeline;
use App\Models\Category;
use App\Models\Item;
use App\Models\Note;
use App\Models\User;
use Filament\Facades\Filament;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;

beforeEach(function () {
    Filament::setCurrentPanel('admin');
    Permission::firstOrCreate(['name' => 'access-admin-panel', 'guard_name' => 'web']);
    Permission::firstOrCreate(['name' => 'add-notes', 'guard_name' => 'web']);
    Permission::firstOrCreate(['name' => 'update-item-status', 'guard_name' => 'web']);
});

describe('Notes Timeline - Viewing', function () {
    test('notes timeline component is visible on item view page', function () {
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
            ->assertSeeLivewire(NotesTimeline::class);
    });

    test('can view notes timeline on item page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $owner = User::factory()->create(['email_verified_at' => now()]);
        $category = Category::factory()->create();
        $user->givePermissionTo('access-admin-panel');

        $item = Item::factory()->create([
            'user_id' => $owner->id,
            'category_id' => $category->id,
            'status' => 'broken',
        ]);

        $note1 = Note::factory()->create([
            'item_id' => $item->id,
            'user_id' => $user->id,
            'status_orig' => 'broken',
            'status_new' => 'broken',
            'note' => 'First note',
        ]);

        $note2 = Note::factory()->create([
            'item_id' => $item->id,
            'user_id' => $user->id,
            'status_orig' => 'broken',
            'status_new' => 'assessed',
            'note' => 'Second note with status change',
        ]);

        Livewire::actingAs($user)
            ->test(NotesTimeline::class, ['item' => $item])
            ->assertSee('First note')
            ->assertSee('Second note with status change')
            ->assertSee($note1->user->name)
            ->assertSee($note2->user->name);
    });

    test('notes are sorted chronologically', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $owner = User::factory()->create(['email_verified_at' => now()]);
        $category = Category::factory()->create();
        $user->givePermissionTo('access-admin-panel');

        $item = Item::factory()->create([
            'user_id' => $owner->id,
            'category_id' => $category->id,
        ]);

        Note::factory()->create([
            'item_id' => $item->id,
            'user_id' => $user->id,
            'note' => 'Oldest note',
            'created_at' => now()->subDays(2),
        ]);

        Note::factory()->create([
            'item_id' => $item->id,
            'user_id' => $user->id,
            'note' => 'Newest note',
            'created_at' => now(),
        ]);

        Livewire::actingAs($user)
            ->test(NotesTimeline::class, ['item' => $item])
            ->assertSeeInOrder(['Oldest note', 'Newest note']);
    });
});

describe('Notes Timeline - Permissions', function () {
    test('item owner can add notes to their own item', function () {
        $owner = User::factory()->create(['email_verified_at' => now()]);
        $category = Category::factory()->create();
        $owner->givePermissionTo('access-admin-panel');

        $item = Item::factory()->create([
            'user_id' => $owner->id,
            'category_id' => $category->id,
            'status' => 'broken',
        ]);

        Livewire::actingAs($owner)
            ->test(NotesTimeline::class, ['item' => $item])
            ->set('data.note', 'My note on my item')
            ->set('data.status_new', 'broken')
            ->call('addNote')
            ->assertHasNoErrors()
            ->assertNotified();

        expect(Note::where('item_id', $item->id)->count())->toBe(1);
        expect(Note::first()->note)->toBe('My note on my item');
        expect(Note::first()->user_id)->toBe($owner->id);
    });

    test('item owner cannot add notes to someone elses item', function () {
        $owner = User::factory()->create(['email_verified_at' => now()]);
        $otherUser = User::factory()->create(['email_verified_at' => now()]);
        $category = Category::factory()->create();
        $otherUser->givePermissionTo('access-admin-panel');

        $item = Item::factory()->create([
            'user_id' => $owner->id,
            'category_id' => $category->id,
        ]);

        Livewire::actingAs($otherUser)
            ->test(NotesTimeline::class, ['item' => $item])
            ->assertDontSee('Add Note');

        expect(Note::where('item_id', $item->id)->count())->toBe(0);
    });

    test('user with add-notes permission can add notes to any item', function () {
        $owner = User::factory()->create(['email_verified_at' => now()]);
        $admin = User::factory()->create(['email_verified_at' => now()]);
        $category = Category::factory()->create();
        $admin->givePermissionTo(['access-admin-panel', 'add-notes']);

        $item = Item::factory()->create([
            'user_id' => $owner->id,
            'category_id' => $category->id,
            'status' => 'broken',
        ]);

        Livewire::actingAs($admin)
            ->test(NotesTimeline::class, ['item' => $item])
            ->set('data.note', 'Admin note on any item')
            ->set('data.status_new', 'broken')
            ->call('addNote')
            ->assertHasNoErrors()
            ->assertNotified();

        expect(Note::where('item_id', $item->id)->count())->toBe(1);
        expect(Note::first()->note)->toBe('Admin note on any item');
        expect(Note::first()->user_id)->toBe($admin->id);
    });

    test('user without permission cannot add notes to others items', function () {
        $owner = User::factory()->create(['email_verified_at' => now()]);
        $regularUser = User::factory()->create(['email_verified_at' => now()]);
        $category = Category::factory()->create();
        $regularUser->givePermissionTo('access-admin-panel');

        $item = Item::factory()->create([
            'user_id' => $owner->id,
            'category_id' => $category->id,
        ]);

        Livewire::actingAs($regularUser)
            ->test(NotesTimeline::class, ['item' => $item])
            ->assertSee("You don't have permission to add notes to this item.", false);

        expect(Note::where('item_id', $item->id)->count())->toBe(0);
    });
});

describe('Notes Timeline - Functionality', function () {
    test('can add note without status change', function () {
        $owner = User::factory()->create(['email_verified_at' => now()]);
        $category = Category::factory()->create();
        $owner->givePermissionTo('access-admin-panel');

        $item = Item::factory()->create([
            'user_id' => $owner->id,
            'category_id' => $category->id,
            'status' => 'broken',
        ]);

        Livewire::actingAs($owner)
            ->test(NotesTimeline::class, ['item' => $item])
            ->set('data.note', 'Just a note without changing status')
            ->set('data.status_new', 'broken')
            ->call('addNote')
            ->assertHasNoErrors();

        $note = Note::first();
        expect($note->note)->toBe('Just a note without changing status');
        expect($note->status_orig)->toBe('broken');
        expect($note->status_new)->toBe('broken');
        expect($item->fresh()->status)->toBe('broken'); // Status unchanged
    });

    test('can add note with status change and item status updates', function () {
        $owner = User::factory()->create(['email_verified_at' => now()]);
        $category = Category::factory()->create();
        $owner->givePermissionTo('access-admin-panel');

        $item = Item::factory()->create([
            'user_id' => $owner->id,
            'category_id' => $category->id,
            'status' => 'broken',
        ]);

        Livewire::actingAs($owner)
            ->test(NotesTimeline::class, ['item' => $item])
            ->set('data.note', 'Item has been assessed')
            ->set('data.status_new', 'assessed')
            ->call('addNote')
            ->assertHasNoErrors();

        $note = Note::first();
        expect($note->note)->toBe('Item has been assessed');
        expect($note->status_orig)->toBe('broken');
        expect($note->status_new)->toBe('assessed');
        expect($item->fresh()->status)->toBe('assessed'); // Status updated!
    });

    test('status transition journey is visible', function () {
        $owner = User::factory()->create(['email_verified_at' => now()]);
        $category = Category::factory()->create();
        $owner->givePermissionTo('access-admin-panel');

        $item = Item::factory()->create([
            'user_id' => $owner->id,
            'category_id' => $category->id,
            'status' => 'broken',
        ]);

        // Create notes showing status progression
        Note::factory()->create([
            'item_id' => $item->id,
            'user_id' => $owner->id,
            'status_orig' => 'broken',
            'status_new' => 'assessed',
            'note' => 'Initial assessment',
            'created_at' => now()->subDays(2),
        ]);

        Note::factory()->create([
            'item_id' => $item->id,
            'user_id' => $owner->id,
            'status_orig' => 'assessed',
            'status_new' => 'awaitingparts',
            'note' => 'Need replacement capacitor',
            'created_at' => now()->subDay(),
        ]);

        Note::factory()->create([
            'item_id' => $item->id,
            'user_id' => $owner->id,
            'status_orig' => 'awaitingparts',
            'status_new' => 'fixed',
            'note' => 'Parts arrived and installed',
            'created_at' => now(),
        ]);

        Livewire::actingAs($owner)
            ->test(NotesTimeline::class, ['item' => $item])
            ->assertSee('Broken')
            ->assertSee('Assessed')
            ->assertSee('Awaiting Parts')
            ->assertSee('Fixed!');
    });

    test('validates note message is required', function () {
        $owner = User::factory()->create(['email_verified_at' => now()]);
        $category = Category::factory()->create();
        $owner->givePermissionTo('access-admin-panel');

        $item = Item::factory()->create([
            'user_id' => $owner->id,
            'category_id' => $category->id,
        ]);

        Livewire::actingAs($owner)
            ->test(NotesTimeline::class, ['item' => $item])
            ->set('data.note', '')
            ->set('data.status_new', 'broken')
            ->call('addNote')
            ->assertHasErrors(['data.note' => 'required']);
    });

    test('status defaults to items current status', function () {
        $owner = User::factory()->create(['email_verified_at' => now()]);
        $category = Category::factory()->create();
        $owner->givePermissionTo('access-admin-panel');

        $item = Item::factory()->create([
            'user_id' => $owner->id,
            'category_id' => $category->id,
            'status' => 'assessed',
        ]);

        $component = Livewire::actingAs($owner)
            ->test(NotesTimeline::class, ['item' => $item]);

        expect($component->get('data.status_new'))->toBe('assessed');
    });

    test('multiple users can add notes to same item showing progression', function () {
        $owner = User::factory()->create(['email_verified_at' => now(), 'name' => 'Item Owner']);
        $fixer = User::factory()->create(['email_verified_at' => now(), 'name' => 'Fixer Person']);
        $category = Category::factory()->create();
        $owner->givePermissionTo('access-admin-panel');
        $fixer->givePermissionTo(['access-admin-panel', 'add-notes']);

        $item = Item::factory()->create([
            'user_id' => $owner->id,
            'category_id' => $category->id,
            'status' => 'broken',
        ]);

        // Owner adds first note
        Note::factory()->create([
            'item_id' => $item->id,
            'user_id' => $owner->id,
            'status_orig' => 'broken',
            'status_new' => 'broken',
            'note' => 'TV not turning on',
            'created_at' => now()->subHours(2),
        ]);

        // Fixer assesses and changes status
        Note::factory()->create([
            'item_id' => $item->id,
            'user_id' => $fixer->id,
            'status_orig' => 'broken',
            'status_new' => 'fixed',
            'note' => 'Replaced fuse, now working',
            'created_at' => now(),
        ]);

        Livewire::actingAs($owner)
            ->test(NotesTimeline::class, ['item' => $item])
            ->assertSee('Item Owner')
            ->assertSee('Fixer Person')
            ->assertSee('TV not turning on')
            ->assertSee('Replaced fuse, now working');
    });
});

describe('Notes Timeline - Status Field Permissions', function () {
    test('item owner can see and use status field on their own item', function () {
        $owner = User::factory()->create(['email_verified_at' => now()]);
        $category = Category::factory()->create();
        $owner->givePermissionTo('access-admin-panel');

        $item = Item::factory()->create([
            'user_id' => $owner->id,
            'category_id' => $category->id,
            'status' => 'broken',
        ]);

        Livewire::actingAs($owner)
            ->test(NotesTimeline::class, ['item' => $item])
            ->assertFormFieldExists('status_new')
            ->set('data.note', 'Updating my item status')
            ->set('data.status_new', 'assessed')
            ->call('addNote')
            ->assertHasNoErrors();

        expect($item->fresh()->status)->toBe('assessed');
    });

    test('user with update-item-status permission can see and use status field on any item', function () {
        $owner = User::factory()->create(['email_verified_at' => now()]);
        $fixer = User::factory()->create(['email_verified_at' => now()]);
        $category = Category::factory()->create();
        $fixer->givePermissionTo(['access-admin-panel', 'add-notes', 'update-item-status']);

        $item = Item::factory()->create([
            'user_id' => $owner->id,
            'category_id' => $category->id,
            'status' => 'broken',
        ]);

        Livewire::actingAs($fixer)
            ->test(NotesTimeline::class, ['item' => $item])
            ->assertFormFieldExists('status_new')
            ->set('data.note', 'Fixer updating status')
            ->set('data.status_new', 'fixed')
            ->call('addNote')
            ->assertHasNoErrors();

        expect($item->fresh()->status)->toBe('fixed');
    });

    test('user with add-notes but without update-item-status permission cannot see status field', function () {
        $owner = User::factory()->create(['email_verified_at' => now()]);
        $noteAdder = User::factory()->create(['email_verified_at' => now()]);
        $category = Category::factory()->create();
        $noteAdder->givePermissionTo(['access-admin-panel', 'add-notes']);

        $item = Item::factory()->create([
            'user_id' => $owner->id,
            'category_id' => $category->id,
            'status' => 'broken',
        ]);

        Livewire::actingAs($noteAdder)
            ->test(NotesTimeline::class, ['item' => $item])
            ->assertFormFieldDoesNotExist('status_new');
    });

    test('user with add-notes but without update-item-status permission can add note without changing status', function () {
        $owner = User::factory()->create(['email_verified_at' => now()]);
        $noteAdder = User::factory()->create(['email_verified_at' => now()]);
        $category = Category::factory()->create();
        $noteAdder->givePermissionTo(['access-admin-panel', 'add-notes']);

        $item = Item::factory()->create([
            'user_id' => $owner->id,
            'category_id' => $category->id,
            'status' => 'broken',
        ]);

        Livewire::actingAs($noteAdder)
            ->test(NotesTimeline::class, ['item' => $item])
            ->set('data.note', 'Adding note without status change')
            ->call('addNote')
            ->assertHasNoErrors();

        $note = Note::where('item_id', $item->id)->first();
        expect($note->note)->toBe('Adding note without status change');
        expect($note->status_orig)->toBe('broken');
        expect($note->status_new)->toBe('broken'); // Status preserved as current status
        expect($item->fresh()->status)->toBe('broken'); // Item status unchanged
    });

    test('user without update-item-status permission cannot change item status even if they try', function () {
        $owner = User::factory()->create(['email_verified_at' => now()]);
        $noteAdder = User::factory()->create(['email_verified_at' => now()]);
        $category = Category::factory()->create();
        $noteAdder->givePermissionTo(['access-admin-panel', 'add-notes']);

        $item = Item::factory()->create([
            'user_id' => $owner->id,
            'category_id' => $category->id,
            'status' => 'broken',
        ]);

        // Even if they somehow set the status_new field, it should be ignored
        Livewire::actingAs($noteAdder)
            ->test(NotesTimeline::class, ['item' => $item])
            ->set('data.note', 'Trying to change status')
            ->set('data.status_new', 'fixed') // This should be ignored
            ->call('addNote')
            ->assertHasNoErrors();

        $note = Note::where('item_id', $item->id)->first();
        expect($note->status_new)->toBe('broken'); // Should keep original status
        expect($item->fresh()->status)->toBe('broken'); // Item status should not change
    });

    test('item owner without explicit update-item-status permission can still update their own item status', function () {
        $owner = User::factory()->create(['email_verified_at' => now()]);
        $category = Category::factory()->create();
        $owner->givePermissionTo('access-admin-panel');
        // Explicitly NOT giving update-item-status permission

        $item = Item::factory()->create([
            'user_id' => $owner->id,
            'category_id' => $category->id,
            'status' => 'broken',
        ]);

        Livewire::actingAs($owner)
            ->test(NotesTimeline::class, ['item' => $item])
            ->assertFormFieldExists('status_new') // Should still see the field
            ->set('data.note', 'Owner updating own item')
            ->set('data.status_new', 'assessed')
            ->call('addNote')
            ->assertHasNoErrors();

        expect($item->fresh()->status)->toBe('assessed');
    });

    test('note without status update permission preserves current status in note record', function () {
        $owner = User::factory()->create(['email_verified_at' => now()]);
        $noteAdder = User::factory()->create(['email_verified_at' => now()]);
        $category = Category::factory()->create();
        $noteAdder->givePermissionTo(['access-admin-panel', 'add-notes']);

        $item = Item::factory()->create([
            'user_id' => $owner->id,
            'category_id' => $category->id,
            'status' => 'assessed',
        ]);

        Livewire::actingAs($noteAdder)
            ->test(NotesTimeline::class, ['item' => $item])
            ->set('data.note', 'Just a note')
            ->call('addNote')
            ->assertHasNoErrors();

        $note = Note::where('item_id', $item->id)->first();
        expect($note->status_orig)->toBe('assessed');
        expect($note->status_new)->toBe('assessed');
    });
});
