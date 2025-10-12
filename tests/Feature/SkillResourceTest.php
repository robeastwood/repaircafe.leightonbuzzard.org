<?php

declare(strict_types=1);

use App\Filament\Resources\Skills\Pages\CreateSkill;
use App\Filament\Resources\Skills\Pages\EditSkill;
use App\Filament\Resources\Skills\Pages\ListSkills;
use App\Models\Skill;
use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Filament\Facades\Filament;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;

use function Pest\Laravel\assertDatabaseHas;

beforeEach(function () {
    Filament::setCurrentPanel('admin');
    Permission::firstOrCreate(['name' => 'access-admin-panel', 'guard_name' => 'web']);
    Permission::firstOrCreate(['name' => 'manage-skills', 'guard_name' => 'web']);
    Permission::firstOrCreate(['name' => 'add-skills', 'guard_name' => 'web']);
});

describe('Skill Resource Authorization', function () {
    test('users with manage-skills permission can see skills in navigation', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-skills']);

        $this->actingAs($user);

        expect(\App\Filament\Resources\Skills\SkillResource::canViewAny())->toBeTrue();
    });

    test('users with add-skills permission can see skills in navigation', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'add-skills']);

        $this->actingAs($user);

        expect(\App\Filament\Resources\Skills\SkillResource::canViewAny())->toBeTrue();
    });

    test('users without manage-skills or add-skills permission cannot see skills in navigation', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo('access-admin-panel');

        $this->actingAs($user);

        expect(\App\Filament\Resources\Skills\SkillResource::canViewAny())->toBeFalse();
    });

    test('guest users cannot see skills in navigation', function () {
        expect(\App\Filament\Resources\Skills\SkillResource::canViewAny())->toBeFalse();
    });

    test('users without appropriate permissions cannot access list page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo('access-admin-panel');

        Livewire::actingAs($user)
            ->test(ListSkills::class)
            ->assertForbidden();
    });

    test('users without appropriate permissions cannot access create page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo('access-admin-panel');

        Livewire::actingAs($user)
            ->test(CreateSkill::class)
            ->assertForbidden();
    });

    test('users without appropriate permissions cannot access edit page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo('access-admin-panel');

        $skill = Skill::factory()->create();

        Livewire::actingAs($user)
            ->test(EditSkill::class, ['record' => $skill->id])
            ->assertForbidden();
    });

    test('users with add-skills permission cannot edit skills', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'add-skills']);

        $skill = Skill::factory()->create();

        Livewire::actingAs($user)
            ->test(EditSkill::class, ['record' => $skill->id])
            ->assertForbidden();
    });

    test('users with add-skills permission cannot delete skills', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'add-skills']);

        $skill = Skill::factory()->create();

        expect($user->can('delete', $skill))->toBeFalse();
    });

    test('users with manage-skills permission can edit skills', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-skills']);

        $skill = Skill::factory()->create();

        expect($user->can('update', $skill))->toBeTrue();
    });

    test('users with manage-skills permission can delete skills', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-skills']);

        $skill = Skill::factory()->create();

        expect($user->can('delete', $skill))->toBeTrue();
    });
});

describe('List Skills', function () {
    test('can render list skills page with manage-skills permission', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-skills']);

        Livewire::actingAs($user)
            ->test(ListSkills::class)
            ->assertSuccessful();
    });

    test('can render list skills page with add-skills permission', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'add-skills']);

        Livewire::actingAs($user)
            ->test(ListSkills::class)
            ->assertSuccessful();
    });

    test('can list skills', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-skills']);

        $skills = Skill::factory()->count(3)->create();

        Livewire::actingAs($user)
            ->test(ListSkills::class)
            ->assertCanSeeTableRecords($skills);
    });

    test('can search skills by name', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-skills']);

        $skills = [
            Skill::factory()->create(['name' => 'Electrical Repair', 'description' => 'Fix electrical items']),
            Skill::factory()->create(['name' => 'Sewing', 'description' => 'Mend clothing']),
            Skill::factory()->create(['name' => 'Woodwork', 'description' => 'Furniture repair']),
        ];

        Livewire::actingAs($user)
            ->test(ListSkills::class)
            ->searchTable('Electrical')
            ->assertCanSeeTableRecords([$skills[0]])
            ->assertCanNotSeeTableRecords([$skills[1], $skills[2]]);
    });

    test('can search skills by description', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-skills']);

        $skills = [
            Skill::factory()->create(['name' => 'Electrical', 'description' => 'Fix electrical items']),
            Skill::factory()->create(['name' => 'Sewing', 'description' => 'Mend clothing']),
        ];

        Livewire::actingAs($user)
            ->test(ListSkills::class)
            ->searchTable('clothing')
            ->assertCanSeeTableRecords([$skills[1]])
            ->assertCanNotSeeTableRecords([$skills[0]]);
    });
});

describe('Create Skill', function () {
    test('can render create skill page with manage-skills permission', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-skills']);

        Livewire::actingAs($user)
            ->test(CreateSkill::class)
            ->assertSuccessful();
    });

    test('can render create skill page with add-skills permission', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'add-skills']);

        Livewire::actingAs($user)
            ->test(CreateSkill::class)
            ->assertSuccessful();
    });

    test('can create skill with manage-skills permission', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-skills']);

        $newSkill = [
            'name' => 'Computer Repair',
            'description' => 'Fixing computers and laptops',
        ];

        Livewire::actingAs($user)
            ->test(CreateSkill::class)
            ->fillForm($newSkill)
            ->call('create')
            ->assertHasNoFormErrors();

        assertDatabaseHas(Skill::class, $newSkill);
    });

    test('can create skill with add-skills permission', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'add-skills']);

        $newSkill = [
            'name' => 'Bicycle Repair',
            'description' => 'Fixing bicycles',
        ];

        Livewire::actingAs($user)
            ->test(CreateSkill::class)
            ->fillForm($newSkill)
            ->call('create')
            ->assertHasNoFormErrors();

        assertDatabaseHas(Skill::class, $newSkill);
    });

    test('can validate required name field when creating skill', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-skills']);

        Livewire::actingAs($user)
            ->test(CreateSkill::class)
            ->fillForm([
                'name' => '',
                'description' => 'Valid description',
            ])
            ->call('create')
            ->assertHasFormErrors(['name' => 'required']);
    });

    test('description is optional when creating skill', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-skills']);

        $newSkill = [
            'name' => 'Painting',
            'description' => '',
        ];

        Livewire::actingAs($user)
            ->test(CreateSkill::class)
            ->fillForm($newSkill)
            ->call('create')
            ->assertHasNoFormErrors();

        assertDatabaseHas(Skill::class, ['name' => 'Painting']);
    });
});

describe('Edit Skill', function () {
    test('can render edit skill page with manage-skills permission', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-skills']);

        $skill = Skill::factory()->create([
            'name' => 'Test Skill',
            'description' => 'Test Description',
        ]);

        Livewire::actingAs($user)
            ->test(EditSkill::class, ['record' => $skill->id])
            ->assertSuccessful();
    });

    test('can retrieve skill data in edit form', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-skills']);

        $skill = Skill::factory()->create([
            'name' => 'Original Skill',
            'description' => 'Original Description',
        ]);

        Livewire::actingAs($user)
            ->test(EditSkill::class, ['record' => $skill->id])
            ->assertSchemaStateSet([
                'name' => 'Original Skill',
                'description' => 'Original Description',
            ]);
    });

    test('can update skill with manage-skills permission', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-skills']);

        $skill = Skill::factory()->create([
            'name' => 'Old Name',
            'description' => 'Old Description',
        ]);

        $updatedData = [
            'name' => 'Updated Name',
            'description' => 'Updated Description',
        ];

        Livewire::actingAs($user)
            ->test(EditSkill::class, ['record' => $skill->id])
            ->fillForm($updatedData)
            ->call('save')
            ->assertHasNoFormErrors();

        assertDatabaseHas(Skill::class, $updatedData);
    });

    test('can validate required name field when updating skill', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-skills']);

        $skill = Skill::factory()->create([
            'name' => 'Test Skill',
            'description' => 'Test Description',
        ]);

        Livewire::actingAs($user)
            ->test(EditSkill::class, ['record' => $skill->id])
            ->fillForm([
                'name' => '',
                'description' => 'Valid Description',
            ])
            ->call('save')
            ->assertHasFormErrors(['name' => 'required']);
    });
});

describe('Delete Skill', function () {
    test('can delete skill from list page with manage-skills permission', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-skills']);

        $skill = Skill::factory()->create([
            'name' => 'Skill to Delete',
            'description' => 'Will be deleted',
        ]);

        Livewire::actingAs($user)
            ->test(ListSkills::class)
            ->selectTableRecords([$skill->id])
            ->callAction(TestAction::make('delete')->table()->bulk());

        expect(Skill::find($skill->id))->toBeNull();
    });

    test('cannot delete skill with only add-skills permission', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'add-skills']);

        $skill = Skill::factory()->create();

        expect($user->cannot('delete', $skill))->toBeTrue();
    });
});

describe('Validation Edge Cases', function () {
    test('validates name field with various invalid inputs', function (mixed $invalidName, string $expectedError) {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-skills']);

        Livewire::actingAs($user)
            ->test(CreateSkill::class)
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

    test('accepts valid skill with special characters', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-skills']);

        $skillData = [
            'name' => 'Computer & Electronics Repair',
            'description' => 'Fixing various devices: phones, tablets, PCs, etc.',
        ];

        Livewire::actingAs($user)
            ->test(CreateSkill::class)
            ->fillForm($skillData)
            ->call('create')
            ->assertHasNoFormErrors();

        assertDatabaseHas(Skill::class, $skillData);
    });
});
