<?php

use App\Http\Controllers\AuthCustomerController;
use App\Livewire\About;
use App\Livewire\Contact;
use App\Livewire\Home;
use App\Livewire\ViewMod;
use Illuminate\Support\Facades\Route;


Route::get('/login', [AuthCustomerController::class, 'index'])->name('customer.login');
Route::post('/login', [AuthCustomerController::class, 'login'])->name('customer.login.submit');
Route::get('/logout', [AuthCustomerController::class, 'logout'])->name('customer.logout');


Route::get('/', Home::class)->name('home');
Route::get('/about', About::class);
Route::get('/contact', Contact::class);

Route::get('/mod/{mod}', ViewMod::class)->name('view.owner');


Route::get('/dashboard', function () {
    return 'Welcome to the customer dashboard!';
})->name('customer.dashboard')->middleware('auth');

// Route::get('/login', CustomerLogin::class)->name('customer.login');
// Route::get('/dashboard', function () {
//     return 'Welcome to the customer dashboard!';
// })->name('customer.dashboard')->middleware('auth');
