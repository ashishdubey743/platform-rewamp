<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Livewire\Vnumber;
use App\Http\Controllers\VNumbersController;

Volt::route('/', 'users.index');
Route::get('/login', [\App\Http\Controllers\ViewController::class, 'login'])->name('login');
// Route::get('/vnumber', [\App\Http\Controllers\ViewController::class, 'vnumber'])->name('vnumber');

// Route::resource('vnumbers', VNumbersController::class);

// link="{{ route('schools.index') }}" no-wire-navigate

Route::get('/vnumber/browse', Vnumber::class)->name('vnumbers.browse');

Route::prefix('vnumbers')->group(function () {
    Route::get('view/{vnumber}', Vnumber::class)->name('vnumbers.view');
});