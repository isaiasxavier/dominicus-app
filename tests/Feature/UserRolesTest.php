<?php

use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('allows super_admin users (Isaias) to access /admin', function () {
    $user = User::where('email', 'isaiasxavier@outlook.com')->first();
    $this->assertNotNull($user);

    actingAs($user);

    $response = get('/admin');

    $response->assertOk();
    $this->assertTrue($user->hasRole('super_admin'));
});


it('allows super_admin users (Simon) to access /admin', function () {
    $user = User::where('email', 'simon@dominicus.com')->first();
    $this->assertNotNull($user);

    actingAs($user);

    $response = get('/admin');

    $response->assertOk();
    $this->assertTrue($user->hasRole('super_admin'));
});



it('allows admin (dennis) users to access /admin', function () {
    $user = User::where('email', 'dennis@dominicus.com')->first();
    $this->assertNotNull($user);

    actingAs($user);

    $response = get('/admin');

    $response->assertOk();
    $this->assertTrue($user->hasRole('admin'));
});

it('allows admin (Yesser) users to access /admin', function () {
    $user = User::where('email', 'yesser@dominicus.com')->first();
    $this->assertNotNull($user);

    actingAs($user);

    $response = get('/admin');

    $response->assertOk();
    $this->assertTrue($user->hasRole('admin'));
});



