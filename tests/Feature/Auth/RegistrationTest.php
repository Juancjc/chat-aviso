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
    config(['app.url' => 'http://wrong-host']);

    $response = $this->withHeader('X-Inertia', 'true')->post(route('register.store'), [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'avatar_emoji' => '👨🏿‍💻',
        'password' => 'password!',
        'password_confirmation' => 'password!',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
    $response->assertInertiaFlash('toast.message', 'Conta criada com sucesso.');
    expect($response->headers->get('Location'))->toBe('/dashboard');
    expect(auth()->user()->avatar_emoji)->toBe('👨🏿‍💻');
});

test('registration accepts passwords longer than nine characters', function () {
    $this->post(route('register.store'), [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'avatar_emoji' => '🙂',
        'password' => 'long-password!',
        'password_confirmation' => 'long-password!',
    ])->assertSessionHasNoErrors();

    $this->assertAuthenticated();
});

test('registration rejects passwords shorter than eight characters', function () {
    $this->post(route('register.store'), [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'avatar_emoji' => '🙂',
        'password' => 'short!',
        'password_confirmation' => 'short!',
    ])->assertSessionHasErrors('password');

    $this->assertGuest();
});

test('registration rejects passwords without a special character', function () {
    $this->post(route('register.store'), [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'avatar_emoji' => '🙂',
        'password' => 'password',
        'password_confirmation' => 'password',
    ])->assertSessionHasErrors('password');

    $this->assertGuest();
});

test('registration rejects text instead of emoji avatar', function () {
    $this->post(route('register.store'), [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'avatar_emoji' => 'avatar',
        'password' => 'password!',
        'password_confirmation' => 'password!',
    ])->assertSessionHasErrors('avatar_emoji');

    $this->assertGuest();
});
