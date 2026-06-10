<?php

use Inertia\Testing\AssertableInertia as Assert;
use Laravel\Fortify\Features;

beforeEach(function () {
    $this->skipUnlessFortifyHas(Features::registration());
});

test('registration screen can be rendered', function () {
    $response = $this->get(route('register'));

    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
        ->component('auth/Register')
        ->has('passwordRules')
        ->has('passwordHint'));
});

test('new users can register', function () {
    $response = $this->post(route('register.store'), [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'avatar_emoji' => '👨🏿‍💻',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
    expect(auth()->user()->avatar_emoji)->toBe('👨🏿‍💻');
});

test('registration rejects text instead of emoji avatar', function () {
    $this->post(route('register.store'), [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'avatar_emoji' => 'avatar',
        'password' => 'password',
        'password_confirmation' => 'password',
    ])->assertSessionHasErrors('avatar_emoji');

    $this->assertGuest();
});
