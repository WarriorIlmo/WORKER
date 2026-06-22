<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here you can register all the routes for your application.
|
*/

// Home page – shows the landing / login screen
Route::get('/', function () {
    return view('welcome');
});

// Auth stubs (replace with real logic later)
Route::post('/login', function () {
    // TODO: validate credentials, redirect, etc.
    return back();
})->name('login');

Route::post('/register', function (\Illuminate\Http\Request $request) {
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'role' => ['required', 'string', 'in:Admin,Employee'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
    ]);

    \App\Models\User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => $validated['password'],
        'role' => $validated['role'],
    ]);

    return redirect('/')->with('status', 'Account created successfully. Please login.');
})->name('register');
