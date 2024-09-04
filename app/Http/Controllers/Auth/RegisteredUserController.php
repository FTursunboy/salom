<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserType;
use App\Providers\RouteServiceProvider;
use App\Services\Common\Helpers\User\UserType\UserTypeEnum;
use App\Services\User\UserServiceContract;
use Dotenv\Util\Regex;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public UserServiceContract $userService;

    public function __construct(UserServiceContract $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'regex:/^\d{12,12}/', 'string', 'unique:'.User::class],
            'privacy_policy' => ['required', 'in:on'],
            'account_type' => ['required', 'in:participant,organizer'],
            'password' => ['required', 'confirmed', 'regex:/^(?=(.*[a-zA-Z]){1,})(?=(.*[0-9]){1,}).{8,}$/'],
        ]);

        $data['user_type_id'] = UserType::query()->where('code', $data['account_type'])->first()->id;

        $user = User::create($data);

        event(new Registered($user));

        Auth::login($user);

        $this->userService->updateSmsCodeForVerification(auth()->user());
        auth()->user()->sendPhoneVerificationNotification();

        session()->flash('flash_message', 'На ваш телефон отправлено сообщение с кодом подтверждения');

        return redirect(RouteServiceProvider::HOME);
    }
}
