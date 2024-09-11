<x-guest-layout>
    <div class="card-body p-4 p-sm-5">
        <div class="row flex-between-center mb-2">
            <div class="col-auto">
                <h5>{{ trans('auth.login') }}</h5>
            </div>
            <div class="col-auto fs--1 text-600">
                <span><a href="{{ route('register') }}">Создайте аккаунт</a></span>
            </div>
        </div>
        <x-input-error :messages="$errors->all()" class="mt-2"/>
        <form method="post" action="{{ route('login') }}" onsubmit="return formSubmit()">
            @csrf
            <div class="mb-3">
                <x-text-input id="phone" type="phone" name="phone" :value="old('phone')" required autofocus
                              autocomplete="phone" placeholder="{{ trans('auth.phone') }}"/>
                <x-input-error :messages="$errors->get('phone')" class="mt-2"/>
            </div>
            <div class="mb-3">
                <x-text-input id="password" type="password" name="password" :value="old('password')" required autofocus
                              autocomplete="password" placeholder="{{ trans('auth.password') }}"/>
            </div>
            <div class="row flex-between-center">
                <!-- Remember Me -->
                <div class="block">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox"
                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                               name="remember">
                        <span class="ml-2 text-sm text-gray-600">{{ __('Запомнить меня') }}</span>
                    </label>
                </div>
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                       href="{{ route('password.request') }}">
                        {{ __('Забыли свой пароль?') }}
                    </a>
                @endif
            </div>
            <div class="mb-3">
                <button class="btn btn-primary d-block w-100 mt-3" type="submit" name="submit">
                    {{ trans('auth.login') }}
                </button>
            </div>
            <div class="mb-3">
                <script async src="https://telegram.org/js/telegram-widget.js?22" data-telegram-login="anons_help_bot" data-size="large" data-auth-url="https://dev.anons.tj/auth/telegram/callback" data-request-access="write"></script>
                  </div>
        </form>
    </div>

</x-guest-layout>
