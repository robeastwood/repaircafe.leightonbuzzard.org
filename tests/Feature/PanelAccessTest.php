<?php

declare(strict_types=1);

use App\Models\User;
use Filament\Facades\Filament;
use Spatie\Permission\Models\Permission;

beforeEach(function () {
    // Set up panels for testing
    Filament::getCurrentPanel();

    // Create the access-admin-panel permission
    Permission::firstOrCreate(['name' => 'access-admin-panel', 'guard_name' => 'web']);
});

describe('Admin Panel Access', function () {
    test('users with access-admin-panel permission and verified email can access admin panel', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo('access-admin-panel');

        Filament::setCurrentPanel('admin');
        $panel = Filament::getCurrentPanel();

        expect($user->canAccessPanel($panel))->toBeTrue();
    });

    test('users without access-admin-panel permission cannot access admin panel even with verified email', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);

        Filament::setCurrentPanel('admin');
        $panel = Filament::getCurrentPanel();

        expect($user->canAccessPanel($panel))->toBeFalse();
    });

    test('users with access-admin-panel permission but unverified email can pass canAccessPanel check', function () {
        $user = User::factory()->create(['email_verified_at' => null]);
        $user->givePermissionTo('access-admin-panel');

        Filament::setCurrentPanel('admin');
        $panel = Filament::getCurrentPanel();

        // canAccessPanel now only checks permission, not email verification
        // Email verification is handled by middleware
        expect($user->canAccessPanel($panel))->toBeTrue();
    });

    test('users without permission and unverified email cannot access admin panel', function () {
        $user = User::factory()->create(['email_verified_at' => null]);

        Filament::setCurrentPanel('admin');
        $panel = Filament::getCurrentPanel();

        expect($user->canAccessPanel($panel))->toBeFalse();
    });

    test('authenticated users without permission can not access admin panel', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);

        $this->actingAs($user)
            ->get('/admin')
            ->assertForbidden();
    });

    test('authenticated users with permission can access admin panel routes', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo('access-admin-panel');

        $this->actingAs($user)
            ->get('/admin')
            ->assertSuccessful();
    });

    test('authenticated users with permission but unverified email are redirected to verify-email page', function () {
        $user = User::factory()->create(['email_verified_at' => null]);
        $user->givePermissionTo('access-admin-panel');

        $this->actingAs($user)
            ->get('/admin')
            ->assertRedirect(route('verification.notice'));
    });
});

describe('Dashboard Panel Access', function () {
    test('users with verified email can access dashboard panel', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);

        Filament::setCurrentPanel('dashboard');
        $panel = Filament::getCurrentPanel();

        expect($user->canAccessPanel($panel))->toBeTrue();
    });

    test('users with unverified email can pass canAccessPanel check for dashboard', function () {
        $user = User::factory()->create(['email_verified_at' => null]);

        Filament::setCurrentPanel('dashboard');
        $panel = Filament::getCurrentPanel();

        // canAccessPanel returns true for dashboard - email verification is handled by middleware
        expect($user->canAccessPanel($panel))->toBeTrue();
    });

    test('users do not need special permissions to access dashboard panel', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        // No permissions granted

        Filament::setCurrentPanel('dashboard');
        $panel = Filament::getCurrentPanel();

        expect($user->canAccessPanel($panel))->toBeTrue();
    });

    test('authenticated users with verified email can access dashboard panel routes', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);

        $this->actingAs($user)
            ->get('/dashboard')
            ->assertSuccessful();
    });

    test('authenticated users with unverified email are redirected to verify-email page', function () {
        $user = User::factory()->create(['email_verified_at' => null]);

        $this->actingAs($user)
            ->get('/dashboard')
            ->assertRedirect(route('verification.notice'));
    });
});

describe('Panel Access Edge Cases', function () {
    test('users cannot access non-existent panels', function () {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $user->givePermissionTo('access-admin-panel');

        // Create a mock panel with a different ID
        $mockPanel = Mockery::mock(\Filament\Panel::class);
        $mockPanel->shouldReceive('getId')->andReturn('non-existent-panel');

        expect($user->canAccessPanel($mockPanel))->toBeFalse();
    });

    test('guests are redirected from admin panel', function () {
        $this->get('/admin')
            ->assertRedirect('/login');
    });

    test('guests are redirected from dashboard panel', function () {
        $this->get('/dashboard')
            ->assertRedirect('/login');
    });
});
