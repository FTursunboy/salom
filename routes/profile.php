<?php

use App\Http\Controllers\Event\EventRegistration\EventRegistrationController;
use App\Http\Controllers\Favorite\FavoriteController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Profile\ProfileEvent\ProfileEventController;

Route::prefix('profile')->middleware(['auth', 'verified.phone'])->name('profile.')->group(function () {

    Route::get('/', [ProfileController::class, 'index'])->name('index');
    Route::get('/view/{user}', [ProfileController::class, 'show'])->name('show');
    Route::get('/setting', [ProfileController::class, 'setting'])->name('setting');
    Route::put('/setting', [ProfileController::class, 'update'])->name('update');
    Route::post('/uploadPhoto', [ProfileController::class, 'uploadPhoto'])->name('uploadPhoto');
    Route::post('/uploadBackgroundImage', [ProfileController::class, 'uploadBackgroundImage'])->name('uploadBackgroundImage');

    Route::resource('events', ProfileEventController::class);
    Route::post('events/uploadImages', [ProfileEventController::class, 'uploadImage'])->name('events.uploadImage');

    Route::get('events/{event}/analytics', [ProfileEventController::class, 'analytics'])->name('events.show.analytics');
    Route::post('events/registration/{event_registration}/confirm', [EventRegistrationController::class, 'confirm'])->name('events.registration.confirm');
    Route::post('events/registration/{event_registration}/cancel', [EventRegistrationController::class, 'cancel'])->name('events.registration.cancel');

    Route::get('favorites', [FavoriteController::class, 'index'])->name('favorite.index');
});
