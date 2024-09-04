<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Services\User\UserServiceContract;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PhoneVerificationNotificationController extends Controller
{
    public UserServiceContract $userService;

    public function __construct(UserServiceContract $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedPhone()) {
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        if (!$this->userService->checkConfirmSmsCode(auth()->user())) {
            $message = $this->userService->getRetrySendSmsAt(auth()->user());

            if ($message) {
                return redirect()->back()->withErrors(['sms_code' => 'Было слышно много попыток входа. Попробуйте через ' . $message]);
            }
        }

        $this->userService->updateSmsCodeForVerification(auth()->user());
        auth()->user()->sendPhoneVerificationNotification();

        session()->flash('flash_message', 'На ваш телефон отправлено сообщение с кодом подтверждения');

        return back()->with('status', 'verification-link-sent');
    }
}
