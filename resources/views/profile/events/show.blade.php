@extends('layouts.main')

@section('content')

    <div class="container mt-3">
        @include('alert.errors')
        <div class="card mb-3">
            <img class="card-img-top" src="{{ asset($event->photo_path) }}" alt="">
            <div class="card-body">
                <div class="row justify-content-between align-items-center">
                    <div class="col">
                        <div class="d-flex">
                            <div class="flex-1 fs--1">
                                <h5 class="fs-0">{{ $event->title }}
                                    <br><span class="fs--1 fw-normal">Рубрика: {{ $event->event_category->name }}</span>
                                </h5>
                                <p class="mb-0">Организатор:
                                    @if($event->organizer)
                                        {{ $event->organizer }}
                                    @else
                                        <a href="{{ route('profile.show', $event->created_by) }}">{{ $event->created_by->full_name }}</a>
                                    @endif
                                </p>
                                @if($event->event_type == 'paid')
                                    <span class="fs-0 text-warning fw-semi-bold">
                                        {{ $event->ticket_amount }} смн
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-auto mt-4 mt-md-0 d-md-flex gap-3 gap-md-0 justify-content-md-between justify-items-md-center">
                        <span class="me-3 pt-1">
                            <span class="fas fa-eye text-danger me-1 text-900"></span>
                            {{ $event->view_count }}
                        </span>
                        <span class="me-3">
                            <button id="add_to_favorite" type="button" class="btn btn-outline-primary @if(!empty($favorite)) d-none @endif" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Добавить в избранное">
                                <i class="far fa-bookmark"></i>
                            </button>
                            <button id="remove_from_favorite" type="button" class="btn btn-primary text-white @if(empty($favorite)) d-none @endif" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Удалить из избранного">
                                <i class="far fa-bookmark"></i>
                            </button>
                        </span>
                        @csrf

                        @if($event->free_entrance)
                            <button class="btn btn-primary px-4 me-3 mb-3" type="button" data-bs-toggle="modal"
                                    data-bs-target="#error-modal">свободный вход
                                <span class="fas fa-check-circle text-white"></span>
                            </button>
                        @endif

                        @if(empty(auth()->user()) && !$event->free_entrance)
                            <button class="btn btn-primary px-4" type="button" data-bs-toggle="modal"
                                    data-bs-target="#error-modal">Записаться
                            </button>
                            <div class="modal fade" id="error-modal" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document"
                                     style="max-width: 500px">
                                    <div class="modal-content position-relative">
                                        <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                                            <button
                                                class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body p-0">
                                            <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                                                <h4 class="mb-1" id="modalExampleDemoLabel">
                                                    Войдите в систему, чтобы записаться на события
                                                </h4>
                                            </div>
                                            <div class="p-4 pb-0">
                                                {!! Form::open(['url' => route('login', ['redirect' => request()->fullUrl()]), 'method' => 'post', 'id' => 'login', 'onSubmit' => 'return formSubmit()']) !!}
                                                <div class="mb-3">
                                                    <div class="row flex-between-center mb-2">
                                                        <div class="col-auto">
                                                            <label class="col-form-label" for="event_schedule_id">Номер
                                                                телефон:</label>
                                                        </div>
                                                        <div class="col-auto fs--1 text-600">
                                                            <span>
                                                                <a href="{{ route('register') }}">
                                                                    Создайте аккаунт</a>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    {{ Form::text('phone', null, ['class' => 'form-control', 'id' => 'phone', 'required' => 'required']) }}
                                                </div>
                                                <div class="mb-3">
                                                    <label class="col-form-label" for="message-text">Пароль:</label>
                                                    {{ Form::password('password', ['class' => 'form-control', 'required' => 'required']) }}
                                                </div>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">
                                                Закрыть
                                            </button>
                                            {{ Form::submit('Войти', ['form' => 'login', 'class' => 'btn btn-primary']) }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @elseif(auth()->user() && $event->created_by_user_id != auth()->user()->id && !$event->free_entrance)
                            @if($registrations->count())
                                <button class="btn btn-primary px-4">
                                    {{ $registrations->first()->event_registration_status->name }}
                                </button>
                            @else
                                <button class="btn btn-primary px-4" type="button" data-bs-toggle="modal"
                                        data-bs-target="#error-modal">Записаться
                                </button>
                                <div class="modal fade" id="error-modal" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document"
                                         style="max-width: 500px">
                                        <div class="modal-content position-relative">
                                            <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                                                <button
                                                    class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-0">
                                                <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                                                    <h4 class="mb-1" id="modalExampleDemoLabel">
                                                        Записываетесь на мероприятие
                                                    </h4>
                                                </div>
                                                <div class="px-4 pb-0">
                                                    {{ Form::open(['url' => route('events.registration.store', $event), 'id' => 'event_registration', 'method' => 'post']) }}

                                                    @foreach($event->additional_fields_json as $field)
                                                        @include('components.fields.' . $field['type'], $field)
                                                    @endforeach

                                                    <div class="mb-3">
                                                        <label class="col-form-label" for="message-text">Сообщение(необязательно):</label>
                                                        <textarea class="form-control" name="message"
                                                                  id="message-text"></textarea>
                                                    </div>
                                                    {{ Form::close() }}
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">
                                                    Закрыть
                                                </button>
                                                {{ Form::submit('Записаться', ['class' => 'btn btn-primary', 'form' => 'event_registration']) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @elseif(auth()->user() == $event->created_by)
                            <a href="{{ route('profile.events.show.analytics', $event) }}"
                               class="justify-content-end btn btn-primary px-4 mb-3">
                                Аналитика
                            </a>
                        @endif

                    </div>
                </div>
            </div>
        </div>

        <div class="row g-0">
            <div class="col-lg-8 pe-lg-2">
                <div class="card mb-3 mb-lg-0">
                    <div class="card-body">
                        <h5 class="fs-0 mb-3">{{ $event->title }}</h5>
                        {!! $event->text !!}

                        <h5 class="fs-0 mt-5 mb-2">Контактная информация</h5>
                        @foreach($event->phones ?? [] as $item)
                            @if($item)
                                <a class="badge border link-secondary me-1 text-decoration-none" href="tel:{{ $item }}">
                                    {{ $item }}
                                </a>
                            @endif
                        @endforeach
                        @foreach($event->sites_validated as $item)
                            <a target="_blank" class="badge border link-secondary me-1 text-decoration-none"
                               href="{{ $item['url'] }}">
                                {!! $item['title'] !!}
                            </a>
                        @endforeach

                        <div id="show_map" class="min-vh-25 w-100 mt-5"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 ps-lg-2">
                <div class="sticky-sidebar" style="top: 16px">
                    <div class="card mb-3 fs--1">
                        <div class="card-body">
                            <h6>Дата и время</h6>
                            @foreach($schedules as $key => $value)
                                <p class="mb-1">
                                    <span class="fw-bold">
                                        {{ \Carbon\Carbon::parse($key)->translatedFormat('d M Y (D)')  }}
                                    </span>
                                    @foreach($value as $item)
                                        <br> {{ $item->start_time->format('H:i') }}
                                        - {{ $item->end_time->format('H:i') }} - {{ $item->title }}
                                    @endforeach
                                </p>
                            @endforeach
                            <h6 class="mt-4">Адрес</h6>
                            <div class="mb-1">
                                {{ $event->city?->name }}, {{ $event->address }} <br>
                            </div>
                            <a href="#show_map">Посмотреть карту</a>
                        </div>
                    </div>

                    @if(auth()->user() && auth()->user()->is_admin)
                        <div class="card mb-3 fs--1">
                            <div class="card-body">
                                <h5>Администрирование</h5>
                                <span>Статус: {{ $event->event_status->name }}</span>
                                <br>
                                @if($event->event_status_id != \App\Services\Common\Helpers\Event\EventStatus\EventStatusHelper::Confirmed->value)
                                    {{ Form::open(['url' => route('admin.events.confirm', $event), 'class' => 'd-grid']) }}
                                    {{ Form::submit('Одобрить события', ['class' => 'btn btn-primary mt-3']) }}
                                    {{ Form::close() }}
                                @endif
                                @if($event->event_status_id != \App\Services\Common\Helpers\Event\EventStatus\EventStatusHelper::Canceled->value)
                                    {{ Form::open(['url' => route('admin.events.cancel', $event), 'class' => 'd-grid']) }}
                                    {{ Form::submit('Отменить события', ['class' => 'btn btn-primary mt-3']) }}
                                    {{ Form::close() }}
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&amp;apikey={{ env('YANDEX_MAP_KEY') }}"
            type="text/javascript"></script>
@endsection

@section('scripts')
    <script src="https://unpkg.com/imask"></script>
    <script>
        ymaps.ready(function () {
            var coords = [{{ $event->latitude }}, {{ $event->longitude }}];
            var myMap = new ymaps.Map('show_map', {
                zoom: 15,
                center: coords,
                controls: []
            });

            var myPlacemark = createPlacemark(coords);
            myMap.geoObjects.add(myPlacemark);

            myPlacemark.properties.set('iconCaption', 'поиск...');
            ymaps.geocode(coords).then(function (res) {
                var firstGeoObject = res.geoObjects.get(0);

                myPlacemark.properties
                    .set({
                        // Формируем строку с данными об объекте.
                        iconCaption: [
                            // Название населенного пункта или вышестоящее административно-территориальное образование.
                            firstGeoObject.getLocalities().length ? firstGeoObject.getLocalities() : firstGeoObject.getAdministrativeAreas(),
                            // Получаем путь до топонима, если метод вернул null, запрашиваем наименование здания.
                            firstGeoObject.getThoroughfare() || firstGeoObject.getPremise()
                        ].filter(Boolean).join(', '),
                        // В качестве контента балуна задаем строку с адресом объекта.
                        balloonContent: firstGeoObject.getAddressLine()
                    });
                document.getElementById('address_detail').innerHTML = firstGeoObject.getAddressLine();
                document.getElementById('address').value = firstGeoObject.getAddressLine();
                document.getElementById('country').value = firstGeoObject.getCountry();

                document.getElementById('city').value = "";
                if (firstGeoObject.getLocalities().length > 0) {
                    document.getElementById('city').value = firstGeoObject.getLocalities()[0];
                }
            });
        });

        function createPlacemark(coords) {
            return new ymaps.Placemark(coords, {
                iconCaption: 'поиск...'
            }, {
                preset: 'islands#violetDotIconWithCaption',
                draggable: false
            });
        }

        $('#add_to_favorite').on('click', function () {
            let token = $("input[name='_token']").val();
            $.ajax({
                url: '{{ route('events.favorite.add', $event) }}',
                method: 'POST',
                data: {
                    _token: token
                },
                success: function () {
                    $('#add_to_favorite').addClass('d-none');
                    $('#remove_from_favorite').removeClass('d-none');
                }
            });
        });

        $('#remove_from_favorite').on('click', function () {
            let token = $("input[name='_token']").val();
            $.ajax({
                url: '{{ route('events.favorite.remove', $event) }}',
                method: 'DELETE',
                data: {
                    _token: token
                },
                success: function () {
                    $('#remove_from_favorite').addClass('d-none');
                    $('#add_to_favorite').removeClass('d-none');
                }
            });
        });

        @if(empty(auth()->user()))
        IMask(
            document.getElementById('phone'),
            {
                mask: '+{992}(00)000-00-00'
            }
        )

        function formSubmit() {
            let phone = $('#phone').val();
            phone = phone.replace('+', '').replace('(', '').replace(')', '').replaceAll('-', '');
            $('#phone').val(phone);
            return true;
        }
        @endif
    </script>
@endsection
