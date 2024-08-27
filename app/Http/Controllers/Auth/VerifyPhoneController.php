<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PhoneVerificationRequest;
use App\Providers\RouteServiceProvider;
use App\Services\User\UserServiceContract;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyPhoneController extends Controller
{
    private UserServiceContract $userService;

    public function __construct(UserServiceContract $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Mark the authenticated user's phone as verified.
     */
    public function __invoke(PhoneVerificationRequest $request): RedirectResponse
    {
        if (!$this->userService->checkConfirmAt(auth()->user())) {
            return redirect()->back()->withErrors(['sms_code' => 'Время действия кода подтверждения истекло запросите повторно']);
        }

        if (!$this->userService->checkConfirmSmsCode(auth()->user())) {
            $message = $this->userService->getRetrySendSmsAt(auth()->user());

            if ($message) {
                return redirect()->back()->withErrors(['sms_code' => 'Было слышно много попыток входа. Попробуйте через ' . $message]);
            }
        }

        if (!$this->userService->tryConfirmSmsCode(auth()->user(), $request->get('sms_code'))) {
            return redirect()->back()->withErrors(['sms_code' => 'Вы ввели неверный код из СМС']);
        }

        if ($request->user()->hasVerifiedPhone()) {
            return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
        }

        if ($request->user()->markPhoneAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
    }
}
