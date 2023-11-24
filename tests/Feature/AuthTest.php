<?php

use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertAuthenticated;
use function Pest\Laravel\assertGuest;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

it('has login page', function () {
    get('/login')
        ->assertOk();
});

test('user can login with right credentials', function() {
    $user = User::factory()->create();

    post(route('login'), [
        'email' => $user->email,
        'password' => 'password',
    ])->assertRedirect('/');

    assertAuthenticated();
});

test('user cannot login with wrong credentials', function() {
    $user = User::factory()->create();

    post(route('login'), [
        'email' => $user->email,
        'password' => 'wrong-password',
    ])->assertStatus(302);

    assertGuest();
});

test('user can logout', function() {
    actingAs(User::factory()->create());

    post(route('logout'))
        ->assertRedirect(route('login'));

    assertGuest();
});