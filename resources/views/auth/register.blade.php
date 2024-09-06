<x-guest-layout>
    <div class="card-body p-4 p-sm-5">
        <div class="row flex-between-center mb-2">
            <div class="col-auto">
                <h5>{{ trans('auth.register') }}</h5>
            </div>
            <div class="col-auto fs--1 text-600">
                <span>
                    <a href="{{ route('login') }}">{{ trans('auth.already_registered') }}</a>
                </span>
            </div>
        </div>
        <x-input-error :messages="$errors->all()" class="mt-2"/>
        <form method="POST" action="{{ route('register') }}" id="form-register" onsubmit="return formSubmit()">
            @csrf
            <div class="row mb-3 mt-3">

                <input type="hidden" name="account_type" value="organizer" id="account_type">
            </div>
            <div class="mb-3">
                <x-input-label for="first_name" :value="trans('auth.first_name')"/>
                <x-text-input id="first_name" type="text" name="first_name" :value="old('first_name')" required
                              autofocus autocomplete="first_name" placeholder="{{ trans('auth.first_name') }}"/>
                <x-input-error :messages="$errors->get('first_name')" class="mt-2"/>
            </div>
            <div class="mb-3">
                <x-input-label for="first_name" :value="trans('auth.last_name')"/>
                <x-text-input id="last_name" type="text" name="last_name" :value="old('last_name')" required autofocus
                              autocomplete="last_name" placeholder="{{ trans('auth.last_name') }}"/>
                <x-input-error :messages="$errors->get('last_name')" class="mt-2"/>
            </div>
            <div class="mb-3">
                <x-input-label for="phone" :value="trans('auth.phone')"/>
                <x-text-input id="phone" type="phone" name="phone" :value="old('phone')" required autofocus
                              autocomplete="phone" placeholder="{{ trans('auth.phone') }}"/>
                <x-input-error :messages="$errors->get('phone')" class="mt-2"/>
            </div>
            <div class="row gx-2 mb-3">
                <div class="col-sm-6">
                    <x-input-label for="password" :value="trans('auth.password')"/>
                    <x-text-input id="password" type="password" name="password" :value="old('password')" required autofocus
                                  autocomplete="password" placeholder="{{ trans('auth.password') }}"/>
                </div>
                <div class="col-sm-6">
                    <x-input-label for="password_confirmation" :value="trans('auth.confirm_password')"/>
                    <x-text-input id="password_confirmation" type="password" name="password_confirmation" :value="old('password_confirmation')" required autofocus
                                 placeholder="{{ trans('auth.confirm_password') }}"/>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2"/>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" required id="privacy_policy" name="privacy_policy"/>
                <label class="form-label" for="privacy_policy">
                    {{ trans('auth.i_accept') }}
                    <a href="{{ route('terms') }}">{{ trans('auth.terms') }} </a>
                    {{ trans('auth.and') }} <a href="#!">{{ trans('auth.privacy_policy') }}</a>
                </label>
            </div>
            <div class="mb-3">
                <x-primary-button class="w-100 mt-3" name="submit" id="submit">
                    {{ __('auth.register_conf') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
