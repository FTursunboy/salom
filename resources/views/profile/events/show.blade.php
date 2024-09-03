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
                            <div class="flex-1 fs--1 events_show">
                                <h3 class="fs-0">{{ $event->title }}
                                    <br><span class="fs--1 fw-normal">Рубрика: {{ $event->event_category->name }}</span>
                                </h3>
                                <p class="mb-0">
                                    Опубликовано: {{ $event->created_at->locale('ru')->translatedFormat('j F') }} -
                                    <span class="me-3 pt-1">
                            <span class="fas fa-eye text-danger me-1 text-900"></span>
                            {{ $event->view_count }}
                        </span>
                                </p>

                                @if($event->event_type == 'paid')
                                    <span class="fs-0 text-warning fw-semi-bold">
                                        {{ $event->ticket_amount }} смн
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div
                        class="col-md-auto mt-md-0 d-md-flex gap-3 gap-md-0 justify-content-md-between justify-items-md-center">
                        @csrf
                        @if(empty(auth()->user()) && !$event->free_entrance)

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
                        @endif

                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="event-header">
                <i class="far fa-calendar-check" style="margin-right: 10px; margin-top: -1px"></i> 12-15 сентября
            </div>
            <div style="padding: 0 18px">
                <div class="event-item">
                    <i style="font-size: 18px; margin-left: 1px" class="fas fa-map-marker-alt"></i>
                    <span class="event-text">г. Душанбе, улица М. Турсунзаде, 45</span>
                </div>
                <div class="event-item">
                    <i style="font-size: 18px " class="far fa-clock"></i>
                    <span class="event-text">19:00</span>
                </div>
                <div class="event-item">
                    <i style="font-size: 18px; margin-left: 3px" class="fas fa-dollar-sign"></i>
                    <span class="event-text" style="font-weight: bold">от 100 сомони</span>
                </div>
                <div class="event-item">
                    <i style="font-size: 18px" class="fas fa-link"></i>
                    <span class="event-text">link</span>
                </div>
            </div>
        </div>


        <div class="row g-0 mt-3">
            <div class="col-lg-8 pe-lg-2">
                <div class="card mb-3 mb-lg-0">
                    <div class="card-body" style="color: black">
                        <h5 style="font-weight: bold; margin-bottom: 10px">О событии</h5>
                        {!! $event->text !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body text-center">
                <!-- Верхняя часть с текстом -->
                <div class="row"
                     style="display: flex; align-items: center; border-bottom: 1px solid black;">
                    <div style="width: 40%; padding: 0;">
                        <h4 style="padding: 20px 0; font-weight: bold; color: black; margin: 0;">Я пойду!</h4>
                    </div>
                    <div class="text-start" style="width: 60%; color: black; font-size: 14px; padding-left: 10px;">
                        <p style="margin: 0; padding-bottom: 10px">Отметьтесь и расскажите об этом событии друзьям, <br> чтобы они смогли к
                            вам присоединиться!</p>
                    </div>
                </div>
                <!-- Нижняя часть с иконками социальных сетей -->
                <div class="d-flex justify-content-center"  >
                    <div class="d-flex align-items-center"
                         style="flex: 1; border-right: 1px solid black; padding: 10px;">
                        <i class="fab fa-telegram" style="font-size: 33px; color: #0088cc;"></i>
                    </div>
                    <div class="d-flex align-items-center"
                         style="flex: 1; border-right: 1px solid black; padding: 10px;">
                        <i class="fab fa-facebook" style="font-size: 33px; color: #1877f2; margin-left: 10px"></i>
                    </div>
                    <div class="d-flex align-items-center"
                         style="flex: 1; border-right: 1px solid black; padding: 10px;">
                        <i class="fab fa-instagram" style="font-size: 33px; color: #e1306c; margin-left: 10px"></i>

                    </div>
                    <div class="d-flex align-items-center"
                         style="flex: 1; border-right: 1px solid black; padding: 10px;">
                        <i class="fab fa-whatsapp" style="font-size: 33px; color: #25D366; margin-left: 10px"></i>

                    </div>
                    <div class="d-flex align-items-center" style="flex: 1; padding: 10px;">
                        <i class="fas fa-link" style="font-size: 33px; color: #000000; margin-left: 10px"></i>
                    </div>
                </div>
            </div>
        </div>
        <!-- Call Button -->
        <!-- Call Button -->
        <div style="margin-top: 20px;" class="card d-flex justify-content-center align-items-center card-stop">
            <div class="event-header call-button-container" style="width: 90%; margin-top: 10px; display: flex; justify-content: center; align-items: center; ">
                Позвонить
            </div>
        </div>
        <div class="stop">

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
        document.addEventListener('scroll', function() {
            var buttonContainer = document.querySelector('.call-button-container');
            var cardElement = document.querySelector('.card-stop');

            var cardPosition = cardElement.getBoundingClientRect().top + window.scrollY;
            var scrollPosition = window.scrollY + window.innerHeight;

            // Если скролл достиг блока .card
            if (scrollPosition >= cardPosition) {
                buttonContainer.style.position = 'relative';
                buttonContainer.style.marginLeft = '-2px';
                buttonContainer.style.top = '0'; // Закрепляем кнопку внутри блока
            } else {
                buttonContainer.style.position = 'fixed';
                buttonContainer.style.bottom = '20px'; // Фиксируем кнопку внизу экрана
                buttonContainer.style.marginLeft = '20px';
                buttonContainer.style.top = ''; // Удаляем top
            }
        });


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
