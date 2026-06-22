<?php

test('the application returns a successful response', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

test('the welcome page can resolve the login and register routes', function () {
    expect(route('login'))->toEndWith('/login');
    expect(route('register'))->toEndWith('/register');
});
