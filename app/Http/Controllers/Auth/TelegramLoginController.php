<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class TelegramLoginController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function login (Request $request)
    {
        $user = Socialite::driver('telegram')->user();
       $d =  User::updateOrCreate([
            'telegram_id' => $user->getId()
        ],[
            'telegram_id' => $user->getId(),
             'first_name' => $user->getName(),
             'user_type_id' => '267777f0-4304-11ee-9288-00ff535e960d',
             'telegram_username' => $user->getNickname(),
         ]);

         Auth::login($d);
         return redirect('/');
    }
}
