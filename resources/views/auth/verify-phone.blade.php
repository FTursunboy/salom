<x-guest-layout>
    <div class="card-body p-4 p-sm-5">
        <h5 class="mb-0">Подтвердите свой номер телефона</h5>
        <small>Введите код подтверждения, который мы отправили на ваш номер телефона в SMS-сообщении.</small>
        <form class="mt-4" method="POST" action="{{ route('verification.phone.verify', Auth::user()) }}">
            @csrf
            <x-text-input id="sms_code" type="text" name="sms_code" :value="old('sms_code')" required
                          autofocus autocomplete="sms_code" placeholder="00000"/>
            <x-input-error :messages="$errors->get('sms_code')" class="mt-2"/>
            <div class="mb-3"></div>
            <button class="btn btn-primary d-block w-100 mt-3" type="submit" name="submit">Подтвердить</button>
        </form>
        <form action="{{ route('verification.phone.send') }}" method="post">
            @csrf
            <button type="submit" class="btn btn-send fs--1 text-600" href="">
                Запросить повторную отправку
                <span class="d-inline-block ms-1">→</span>
            </button>
        </form>

    </div>

    @if(session()->get('flash_message'))
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 11">
            <div id="liveToast" class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <strong class="me-auto">{{ env('APP_NAME') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Закрыть"></button>
                </div>
                <div class="toast-body">
                    {{ session()->get('flash_message') }}
                </div>
            </div>
        </div>
    @endif
</x-guest-layout>
