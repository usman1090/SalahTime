<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\PrayerController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware(['auth'])->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    Route::post('/prayers/store', [PrayerController::class, 'store'])
        ->name('prayers.store');

    Route::delete('/prayers/{prayerRecord}', [PrayerController::class, 'destroy'])
    ->name('prayers.destroy');
    
    Route::get('/groups/join', [GroupController::class, 'joinForm'])
    ->name('groups.join.form');

    Route::post('/groups/join', [GroupController::class, 'join'])
    ->name('groups.join');

    Route::resource('/groups', GroupController::class);
    
    
});

require __DIR__.'/auth.php';
