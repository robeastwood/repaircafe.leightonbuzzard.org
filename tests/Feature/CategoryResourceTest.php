<?php

declare(strict_types=1);

use App\Filament\Resources\Categories\Pages\CreateCategory;
use App\Filament\Resources\Categories\Pages\EditCategory;
use App\Filament\Resources\Categories\Pages\ListCategories;
use App\Models\Category;
use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Filament\Facades\Filament;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;

use function Pest\Laravel\assertDatabaseHas;

beforeEach(function () {
    Filament::setCurrentPanel('admin');
    Permission::firstOrCreate(['name' => 'access-admin-panel', 'guard_name' => 'web']);
    Permission::firstOrCreate(['name' => 'manage-categories', 'guard_name' => 'web']);
});

describe('Category Resource Authorization', function () {
    test('users with manage-categories permission can see categories in navigation', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-categories']);

        $this->actingAs($user);

        expect(\App\Filament\Resources\Categories\CategoryResource::canViewAny())->toBeTrue();
    });

    test('users without manage-categories permission cannot see categories in navigation', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo('access-admin-panel');

        $this->actingAs($user);

        expect(\App\Filament\Resources\Categories\CategoryResource::canViewAny())->toBeFalse();
    });

    test('guest users cannot see categories in navigation', function () {
        expect(\App\Filament\Resources\Categories\CategoryResource::canViewAny())->toBeFalse();
    });

    test('users without manage-categories permission cannot access list page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo('access-admin-panel');

        Livewire::actingAs($user)
            ->test(ListCategories::class)
            ->assertForbidden();
    });

    test('users without manage-categories permission cannot access create page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo('access-admin-panel');

        Livewire::actingAs($user)
            ->test(CreateCategory::class)
            ->assertForbidden();
    });

    test('users without manage-categories permission cannot access edit page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo('access-admin-panel');

        $category = Category::factory()->create();

        Livewire::actingAs($user)
            ->test(EditCategory::class, ['record' => $category->id])
            ->assertForbidden();
    });
});

describe('List Categories', function () {
    test('can render list categories page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-categories']);

        Livewire::actingAs($user)
            ->test(ListCategories::class)
            ->assertSuccessful();
    });

    test('can list categories', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-categories']);

        $categories = Category::factory()->count(3)->create();

        Livewire::actingAs($user)
            ->test(ListCategories::class)
            ->assertCanSeeTableRecords($categories);
    });

    test('can search categories by name', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-categories']);

        $categories = [
            Category::factory()->create(['name' => 'Electronics', 'description' => 'Electronic devices']),
            Category::factory()->create(['name' => 'Appliances', 'description' => 'Household appliances']),
            Category::factory()->create(['name' => 'Furniture', 'description' => 'Home furniture']),
        ];

        Livewire::actingAs($user)
            ->test(ListCategories::class)
            ->searchTable('Electronics')
            ->assertCanSeeTableRecords([$categories[0]])
            ->assertCanNotSeeTableRecords([$categories[1], $categories[2]]);
    });

    test('trashed filter exists', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-categories']);

        Livewire::actingAs($user)
            ->test(ListCategories::class)
            ->assertTableFilterExists('trashed');
    })->todo('Full trashed filter testing requires investigation - filter not applying correctly in tests despite deferFilters(false)');
});

describe('Create Category', function () {
    test('can render create category page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-categories']);

        Livewire::actingAs($user)
            ->test(CreateCategory::class)
            ->assertSuccessful();
    });

    test('can create category', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-categories']);

        $newCategory = [
            'name' => 'New Electronics',
            'description' => 'All electronic items',
            'powered' => 'mains',
        ];

        Livewire::actingAs($user)
            ->test(CreateCategory::class)
            ->fillForm($newCategory)
            ->call('create')
            ->assertHasNoFormErrors();

        assertDatabaseHas(Category::class, $newCategory);
    });

    test('can create category without power', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-categories']);

        $newCategory = [
            'name' => 'Books',
            'description' => 'All kinds of books',
            'powered' => 'no',
        ];

        Livewire::actingAs($user)
            ->test(CreateCategory::class)
            ->fillForm($newCategory)
            ->call('create')
            ->assertHasNoFormErrors();

        assertDatabaseHas(Category::class, $newCategory);
    });

    test('can create category with batteries', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-categories']);

        $newCategory = [
            'name' => 'Portable Electronics',
            'description' => 'Battery powered devices',
            'powered' => 'batteries',
        ];

        Livewire::actingAs($user)
            ->test(CreateCategory::class)
            ->fillForm($newCategory)
            ->call('create')
            ->assertHasNoFormErrors();

        assertDatabaseHas(Category::class, $newCategory);
    });

    test('can validate required fields when creating category', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-categories']);

        Livewire::actingAs($user)
            ->test(CreateCategory::class)
            ->fillForm([
                'name' => '',
                'description' => 'Some description',
            ])
            ->call('create')
            ->assertHasFormErrors(['name' => 'required']);
    });
});

describe('Edit Category', function () {
    test('can render edit category page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-categories']);

        $category = Category::factory()->create([
            'name' => 'Test Category',
            'description' => 'Test Description',
            'powered' => 'no',
        ]);

        Livewire::actingAs($user)
            ->test(EditCategory::class, ['record' => $category->id])
            ->assertSuccessful();
    });

    test('can retrieve category data in edit form', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-categories']);

        $category = Category::factory()->create([
            'name' => 'Original Name',
            'description' => 'Original Description',
            'powered' => 'mains',
        ]);

        Livewire::actingAs($user)
            ->test(EditCategory::class, ['record' => $category->id])
            ->assertSchemaStateSet([
                'name' => 'Original Name',
                'description' => 'Original Description',
                'powered' => 'mains',
            ]);
    });

    test('can update category', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-categories']);

        $category = Category::factory()->create([
            'name' => 'Old Name',
            'description' => 'Old Description',
            'powered' => 'no',
        ]);

        $updatedData = [
            'name' => 'Updated Name',
            'description' => 'Updated Description',
            'powered' => 'batteries',
        ];

        Livewire::actingAs($user)
            ->test(EditCategory::class, ['record' => $category->id])
            ->fillForm($updatedData)
            ->call('save')
            ->assertHasNoFormErrors();

        assertDatabaseHas(Category::class, $updatedData);
    });

    test('can validate required fields when updating category', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-categories']);

        $category = Category::factory()->create([
            'name' => 'Test Category',
            'description' => 'Test Description',
        ]);

        Livewire::actingAs($user)
            ->test(EditCategory::class, ['record' => $category->id])
            ->fillForm([
                'name' => '',
                'description' => 'Valid description',
            ])
            ->call('save')
            ->assertHasFormErrors(['name' => 'required']);
    });
});

describe('Delete Category', function () {
    test('can soft delete category from list page', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-categories']);

        $category = Category::factory()->create([
            'name' => 'Category to Delete',
            'description' => 'Will be deleted',
        ]);

        Livewire::actingAs($user)
            ->test(ListCategories::class)
            ->selectTableRecords([$category->id])
            ->callAction(TestAction::make('delete')->table()->bulk());

        expect($category->fresh()->trashed())->toBeTrue();
    });

    test('can restore soft deleted category', function () {
        Permission::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']);

        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-categories', 'super-admin']);

        $category = Category::factory()->create([
            'name' => 'Deleted Category',
            'description' => 'Was deleted',
        ]);
        $category->delete();

        Livewire::actingAs($user)
            ->test(ListCategories::class)
            ->filterTable('trashed', 'only')
            ->selectTableRecords([$category->id])
            ->callAction(TestAction::make('restore')->table()->bulk());

        expect($category->fresh()->trashed())->toBeFalse();
    });

    test('can force delete category', function () {
        Permission::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']);

        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-categories', 'super-admin']);

        $category = Category::factory()->create([
            'name' => 'Category to Force Delete',
            'description' => 'Will be permanently deleted',
        ]);
        $category->delete();

        Livewire::actingAs($user)
            ->test(ListCategories::class)
            ->filterTable('trashed', 'only')
            ->selectTableRecords([$category->id])
            ->callAction(TestAction::make('forceDelete')->table()->bulk());

        expect(Category::withTrashed()->find($category->id))->toBeNull();
    });
});

describe('Validation Edge Cases', function () {
    test('validates name field with various invalid inputs', function (mixed $invalidName, string $expectedError) {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-categories']);

        Livewire::actingAs($user)
            ->test(CreateCategory::class)
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

    test('accepts valid category with special characters', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-categories']);

        $categoryData = [
            'name' => "TV's & Audio Equipment",
            'description' => 'A category with special characters: @, #, $, %, &, *',
            'powered' => 'mains',
        ];

        Livewire::actingAs($user)
            ->test(CreateCategory::class)
            ->fillForm($categoryData)
            ->call('create')
            ->assertHasNoFormErrors();

        assertDatabaseHas(Category::class, $categoryData);
    });

    test('can create category with all power options', function (string $powerOption) {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo(['access-admin-panel', 'manage-categories']);

        $categoryData = [
            'name' => "Test Category - {$powerOption}",
            'description' => 'Testing power options',
            'powered' => $powerOption,
        ];

        Livewire::actingAs($user)
            ->test(CreateCategory::class)
            ->fillForm($categoryData)
            ->call('create')
            ->assertHasNoFormErrors();

        assertDatabaseHas(Category::class, $categoryData);
    })->with(['no', 'mains', 'batteries', 'other', 'unknown']);
});
