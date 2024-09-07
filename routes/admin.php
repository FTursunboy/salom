<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Event\EventController;
use App\Http\Controllers\Admin\User\UserController;

Route::prefix('admin')->middleware(['auth', 'verified.phone', 'admin'])->name('admin.')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/events', [EventController::class, 'index'])->name('events.index');

    Route::post('/events/{event}/confirm', [EventController::class, 'confirm'])->name('events.confirm');
    Route::post('/events/{event}/cancel', [EventController::class, 'cancel'])->name('events.cancel');
});
