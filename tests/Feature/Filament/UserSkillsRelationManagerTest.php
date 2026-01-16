<?php

declare(strict_types=1);

use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\RelationManagers\SkillsRelationManager;
use App\Models\Skill;
use App\Models\User;
use Filament\Actions\AttachAction;
use Filament\Actions\DetachAction;
use Filament\Actions\Testing\TestAction;
use Filament\Facades\Filament;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;

beforeEach(function () {
    Filament::setCurrentPanel('admin');
    Permission::firstOrCreate(['name' => 'access-admin-panel', 'guard_name' => 'web']);
    Permission::firstOrCreate(['name' => 'manage-users', 'guard_name' => 'web']);
    Permission::firstOrCreate(['name' => 'can-fix', 'guard_name' => 'web']);
    Permission::firstOrCreate(['name' => 'add-skills', 'guard_name' => 'web']);
    Permission::firstOrCreate(['name' => 'manage-skills', 'guard_name' => 'web']);
});

describe('Skills RelationManager - Visibility', function () {
    test('relation manager is visible for users with can-fix permission', function () {
        $admin = User::factory()->create(['email_verified_at' => now()]);
        $admin->givePermissionTo(['access-admin-panel', 'manage-users']);

        $fixer = User::factory()->create(['email_verified_at' => now()]);
        $fixer->givePermissionTo('can-fix');

        Livewire::actingAs($admin)
            ->test(EditUser::class, ['record' => $fixer->id])
            ->assertSeeLivewire(SkillsRelationManager::class);
    });

    test('relation manager is not visible for users without can-fix permission', function () {
        $admin = User::factory()->create(['email_verified_at' => now()]);
        $admin->givePermissionTo(['access-admin-panel', 'manage-users']);

        $regularUser = User::factory()->create(['email_verified_at' => now()]);

        Livewire::actingAs($admin)
            ->test(EditUser::class, ['record' => $regularUser->id])
            ->assertDontSeeLivewire(SkillsRelationManager::class);
    });
});

describe('Skills RelationManager - Attach/Detach Authorization', function () {
    test('users with manage-users permission can attach skills', function () {
        $admin = User::factory()->create(['email_verified_at' => now()]);
        $admin->givePermissionTo(['access-admin-panel', 'manage-users']);

        $fixer = User::factory()->create(['email_verified_at' => now()]);
        $fixer->givePermissionTo('can-fix');

        Livewire::actingAs($admin)
            ->test(SkillsRelationManager::class, [
                'ownerRecord' => $fixer,
                'pageClass' => EditUser::class,
            ])
            ->assertActionExists(TestAction::make(AttachAction::class)->table());
    });

    test('user can manage their own skills', function () {
        $fixer = User::factory()->create(['email_verified_at' => now()]);
        $fixer->givePermissionTo(['access-admin-panel', 'can-fix']);

        Livewire::actingAs($fixer)
            ->test(SkillsRelationManager::class, [
                'ownerRecord' => $fixer,
                'pageClass' => EditUser::class,
            ])
            ->assertActionExists(TestAction::make(AttachAction::class)->table());
    });

    test('users without manage-users permission cannot attach skills to others', function () {
        $regularUser = User::factory()->create(['email_verified_at' => now()]);
        $regularUser->givePermissionTo('access-admin-panel');

        $fixer = User::factory()->create(['email_verified_at' => now()]);
        $fixer->givePermissionTo('can-fix');

        Livewire::actingAs($regularUser)
            ->test(SkillsRelationManager::class, [
                'ownerRecord' => $fixer,
                'pageClass' => EditUser::class,
            ])
            ->assertActionHidden(TestAction::make(AttachAction::class)->table());
    });

    test('users can attach existing skills', function () {
        $admin = User::factory()->create(['email_verified_at' => now()]);
        $admin->givePermissionTo(['access-admin-panel', 'manage-users']);

        $fixer = User::factory()->create(['email_verified_at' => now()]);
        $fixer->givePermissionTo('can-fix');

        $skill = Skill::factory()->create(['name' => 'Electrical Repairs']);

        expect($fixer->skills()->pluck('id'))->not->toContain($skill->id);

        Livewire::actingAs($admin)
            ->test(SkillsRelationManager::class, [
                'ownerRecord' => $fixer,
                'pageClass' => EditUser::class,
            ])
            ->callAction(TestAction::make(AttachAction::class)->table(), ['recordId' => $skill->id])
            ->assertHasNoErrors();

        expect($fixer->fresh()->skills()->pluck('id'))->toContain($skill->id);
    });

    test('users can detach skills', function () {
        $admin = User::factory()->create(['email_verified_at' => now()]);
        $admin->givePermissionTo(['access-admin-panel', 'manage-users']);

        $fixer = User::factory()->create(['email_verified_at' => now()]);
        $fixer->givePermissionTo('can-fix');

        $skill = Skill::factory()->create(['name' => 'Plumbing']);
        $fixer->skills()->attach($skill);

        expect($fixer->fresh()->skills()->pluck('id'))->toContain($skill->id);

        Livewire::actingAs($admin)
            ->test(SkillsRelationManager::class, [
                'ownerRecord' => $fixer,
                'pageClass' => EditUser::class,
            ])
            ->callTableAction(DetachAction::class, $skill)
            ->assertHasNoErrors();

        expect($fixer->fresh()->skills()->pluck('id'))->not->toContain($skill->id);
    });
});

describe('Skills RelationManager - Create Action Authorization', function () {
    test('users with add-skills permission can see create action', function () {
        $admin = User::factory()->create(['email_verified_at' => now()]);
        $admin->givePermissionTo(['access-admin-panel', 'manage-users', 'add-skills']);

        $fixer = User::factory()->create(['email_verified_at' => now()]);
        $fixer->givePermissionTo('can-fix');

        Livewire::actingAs($admin)
            ->test(SkillsRelationManager::class, [
                'ownerRecord' => $fixer,
                'pageClass' => EditUser::class,
            ])
            ->assertActionExists(TestAction::make('create')->table());
    });

    test('users without add-skills permission cannot see create action', function () {
        $admin = User::factory()->create(['email_verified_at' => now()]);
        $admin->givePermissionTo(['access-admin-panel', 'manage-users']);

        $fixer = User::factory()->create(['email_verified_at' => now()]);
        $fixer->givePermissionTo('can-fix');

        Livewire::actingAs($admin)
            ->test(SkillsRelationManager::class, [
                'ownerRecord' => $fixer,
                'pageClass' => EditUser::class,
            ])
            ->assertActionHidden(TestAction::make('create')->table());
    });

    test('users with add-skills permission can create new skills and attach them', function () {
        $admin = User::factory()->create(['email_verified_at' => now()]);
        $admin->givePermissionTo(['access-admin-panel', 'manage-users', 'add-skills']);

        $fixer = User::factory()->create(['email_verified_at' => now()]);
        $fixer->givePermissionTo('can-fix');

        $skillData = [
            'name' => 'Carpentry',
            'description' => 'Wood repair and construction',
        ];

        Livewire::actingAs($admin)
            ->test(SkillsRelationManager::class, [
                'ownerRecord' => $fixer,
                'pageClass' => EditUser::class,
            ])
            ->callAction(TestAction::make('create')->table(), $skillData)
            ->assertHasNoErrors();

        $this->assertDatabaseHas('skills', [
            'name' => 'Carpentry',
            'description' => 'Wood repair and construction',
        ]);
    });
});

describe('Skills RelationManager - Delete Action Authorization', function () {
    test('users with manage-skills permission can see delete action', function () {
        $admin = User::factory()->create(['email_verified_at' => now()]);
        $admin->givePermissionTo(['access-admin-panel', 'manage-users', 'manage-skills']);

        $fixer = User::factory()->create(['email_verified_at' => now()]);
        $fixer->givePermissionTo('can-fix');

        $skill = Skill::factory()->create(['name' => 'Test Skill']);
        $fixer->skills()->attach($skill);

        Livewire::actingAs($admin)
            ->test(SkillsRelationManager::class, [
                'ownerRecord' => $fixer,
                'pageClass' => EditUser::class,
            ])
            ->assertActionExists(TestAction::make('delete')->table());
    });

    test('users without manage-skills permission cannot see delete action', function () {
        $admin = User::factory()->create(['email_verified_at' => now()]);
        $admin->givePermissionTo(['access-admin-panel', 'manage-users']);

        $fixer = User::factory()->create(['email_verified_at' => now()]);
        $fixer->givePermissionTo('can-fix');

        $skill = Skill::factory()->create(['name' => 'Test Skill']);
        $fixer->skills()->attach($skill);

        Livewire::actingAs($admin)
            ->test(SkillsRelationManager::class, [
                'ownerRecord' => $fixer,
                'pageClass' => EditUser::class,
            ])
            ->assertTableActionHidden('delete', $skill);
    });
});

describe('Skills RelationManager - Display', function () {
    test('displays skills attached to user', function () {
        $admin = User::factory()->create(['email_verified_at' => now()]);
        $admin->givePermissionTo(['access-admin-panel', 'manage-users']);

        $fixer = User::factory()->create(['email_verified_at' => now()]);
        $fixer->givePermissionTo('can-fix');

        $skills = Skill::factory()->count(3)->create();
        $fixer->skills()->attach($skills);

        Livewire::actingAs($admin)
            ->test(SkillsRelationManager::class, [
                'ownerRecord' => $fixer,
                'pageClass' => EditUser::class,
            ])
            ->assertCanSeeTableRecords($skills);
    });

    test('only displays skills for the specific user', function () {
        $admin = User::factory()->create(['email_verified_at' => now()]);
        $admin->givePermissionTo(['access-admin-panel', 'manage-users']);

        $fixer1 = User::factory()->create(['email_verified_at' => now()]);
        $fixer1->givePermissionTo('can-fix');

        $fixer2 = User::factory()->create(['email_verified_at' => now()]);
        $fixer2->givePermissionTo('can-fix');

        $skill1 = Skill::factory()->create(['name' => 'Skill 1']);
        $skill2 = Skill::factory()->create(['name' => 'Skill 2']);

        $fixer1->skills()->attach($skill1);
        $fixer2->skills()->attach($skill2);

        Livewire::actingAs($admin)
            ->test(SkillsRelationManager::class, [
                'ownerRecord' => $fixer1,
                'pageClass' => EditUser::class,
            ])
            ->assertCanSeeTableRecords([$skill1])
            ->assertCanNotSeeTableRecords([$skill2]);
    });

    test('displays skill details correctly', function () {
        $admin = User::factory()->create(['email_verified_at' => now()]);
        $admin->givePermissionTo(['access-admin-panel', 'manage-users']);

        $fixer = User::factory()->create(['email_verified_at' => now()]);
        $fixer->givePermissionTo('can-fix');

        $skill = Skill::factory()->create([
            'name' => 'Advanced Electronics',
            'description' => 'Circuit board repair',
        ]);
        $fixer->skills()->attach($skill);

        Livewire::actingAs($admin)
            ->test(SkillsRelationManager::class, [
                'ownerRecord' => $fixer,
                'pageClass' => EditUser::class,
            ])
            ->assertCanSeeTableRecords([$skill])
            ->assertSee('Advanced Electronics');
    });
});
