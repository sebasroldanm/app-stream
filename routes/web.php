<?php

use App\Livewire\About;
use App\Livewire\Contact;
use App\Livewire\CustomerLogin;
use App\Livewire\Home;
use App\Livewire\ViewMod;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('home');
Route::get('/about', About::class);
Route::get('/contact', Contact::class);

Route::get('/mod/{mod}', ViewMod::class);

Route::get('/login', CustomerLogin::class)->name('customer.login');

Route::get('/dashboard', function () {
    return 'Welcome to the customer dashboard!';
})->name('customer.dashboard')->middleware('auth');

// Route::get('/login', CustomerLogin::class)->name('customer.login');
// Route::get('/dashboard', function () {
//     return 'Welcome to the customer dashboard!';
// })->name('customer.dashboard')->middleware('auth');
