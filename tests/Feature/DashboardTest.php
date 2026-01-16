<?php

use App\Models\User;

test('guests are redirected to the login page', function () {
    $this->get('/dashboard')->assertRedirect('/login');
});

test('authenticated users with verified email can visit the dashboard', function () {
    $user = User::factory()->create(['email_verified_at' => now()]);

    $this->actingAs($user);

    $this->get('/dashboard')->assertStatus(200);
});

test('authenticated users without verified email are redirected to verify-email', function () {
    $user = User::factory()->create(['email_verified_at' => null]);

    $this->actingAs($user);

    $this->get('/dashboard')->assertRedirect(route('verification.notice'));
});
