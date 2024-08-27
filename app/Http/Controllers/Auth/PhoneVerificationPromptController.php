<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PhoneVerificationPromptController extends Controller
{
    /**
     * Display the phone verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        return $request->user()->hasVerifiedPhone()
                    ? redirect()->intended(RouteServiceProvider::HOME)
                    : view('auth.verify-phone');
    }
}
