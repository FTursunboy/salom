<?php

use App\Http\Controllers\Event\EventController;
use App\Http\Controllers\Event\EventRegistration\EventRegistrationController;
use App\Http\Controllers\Favorite\FavoriteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Ticket\TicketController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('send-sms', function () {
    \App\Gateway\Sms\OsonSmsGateway::send('992929211411', 'Салом. Код подтверждения: 14115', '2e9e2e15-4364-11ee-9288-00ff535e9603');
});

Route::get('sendsms_v1.php', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => \Carbon\Carbon::now()->toDateTimeString(),
        'txn_id' => '2e9e2e15-4364-11ee-9288-00ff535e960d',
        'msg_id' => '64874747',
        'smsc_msg_id' => '+7318bbe6',
        'smsc_msg_status' => 'success',
        'smsc_msg_parts' => '1',
    ]);
});

Route::get('terms', function () {
    return view('terms');
})->name('terms');

Route::get('about', function () {
    return view('about');
})->name('about');

require __DIR__.'/auth.php';

require __DIR__.'/profile.php';

require __DIR__.'/admin.php';


Route::get('events/{event}', [EventController::class, 'show'])->name('events.show');

Route::post('events/{event}/registration', [EventRegistrationController::class, 'store'])
    ->name('events.registration.store');

Route::post('events/{event}/newsletter/send', [EventRegistrationController::class, 'newsletter'])
    ->name('events.newsletter.store');

Route::post('events/{event}/favorite', [FavoriteController::class, 'add'])
    ->name('events.favorite.add');
Route::delete('events/{event}/favorite', [FavoriteController::class, 'remove'])
    ->name('events.favorite.remove');

Route::get('tickets', [TicketController::class, 'index'])->name('tickets.index');

Route::get('telegram/redirect', function () {
    return Socialite::driver('telegram')->redirect();
});

Route::get('telegram/callback', function () {
    return "123";
});
