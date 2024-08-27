@extends('layouts.main')

@section('content')

    <div class="container mt-3">
        @include('alert.errors')
        @include('alert.success')
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
                                <p class="mb-0">Организатор: <a href="{{ route('profile.show', $event->created_by) }}">{{ $event->created_by->full_name }}</a></p>
                                @if($event->event_type == 'paid')
                                    <span class="fs-0 text-warning fw-semi-bold">
                                        {{ $event->ticket_amount }} смн
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-auto mt-4 mt-md-0">
                        <span class="me-2">
                            <span class="fas fa-eye text-danger me-1 text-900"></span>
                            {{ $event->view_count }}
                        </span>

                    </div>
                </div>
            </div>
        </div>

        <div class="row g-0">
            <div class="col-lg-8 pe-lg-2">
                <div class="card mb-3 mb-lg-0">
                    <div class="card-header">
                        <div class="row d-flex justify-content-between">
                            <div class="col-auto">
                                <h5>Заявки на участие</h5>
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#error-modal">Отправить рассылку</button>
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
                                                        Рассылка будет отправлена всем зарегистрированным пользователям
                                                    </h4>
                                                </div>
                                                <div class="px-4 pb-0">
                                                    {{ Form::open(['url' => route('events.newsletter.store', $event), 'id' => 'event_registration', 'method' => 'post']) }}
                                                    <div class="mb-3">
                                                        <label class="col-form-label" for="message-text">Сообщение:</label>
                                                        <textarea class="form-control" name="message"
                                                                  id="message-text" maxlength="100"></textarea>
                                                    </div>
                                                    {{ Form::close() }}
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">
                                                    Закрыть
                                                </button>
                                                {{ Form::submit('Отправить', ['class' => 'btn btn-primary', 'form' => 'event_registration']) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($registrations->count() == 0)
                            <div class="text-center pt-3 pb-5">
                                Заявок на участие пока нет
                            </div>
                        @else
                            <div class="table-responsive scrollbar">
                                <table class="table table-hover table-striped overflow-hidden">
                                    <thead>
                                    <tr>
                                        <th scope="col">ФИО</th>
                                        <th scope="col">Номер телефон</th>
                                        @foreach($event->additional_fields_json as $field)
                                            <th scope="col">{{ $field['title'] }}</th>
                                        @endforeach
                                        <th scope="col">Сообщение</th>
                                        <th scope="col">Статус</th>
                                        <th scope="col">Действия</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($registrations as $registration)
                                        <tr class="align-middle">
                                            <td class="text-nowrap">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-xl">
                                                        @if($registration->user->photo)
                                                            <img class="rounded-circle"
                                                                 src="../../assets/img/team/4.jpg"
                                                                 alt=""/>
                                                        @else
                                                            <div class="avatar-name rounded-circle">
                                                            <span>
                                                                {{ $registration->user->first_name[0] . $registration->user->last_name[0] }}
                                                            </span>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <div class="ms-2">
                                                        {{ $registration->user->full_name }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-nowrap">
                                                {{ $registration->user->phone_formatted }}
                                            </td>
                                            @foreach($event->additional_fields_json as $field)
                                                <td class="text-nowrap">
                                                    @php
                                                        $name = str_replace('additional_fields_json[', '', $field['name']);
                                                        $name = str_replace(']', '', $name);
                                                    @endphp
                                                    {{ $registration->additional_fields_json[$name] }}
                                                </td>
                                            @endforeach
                                            <td class="text-nowrap">
                                                {{ $registration->message }}
                                            </td>
                                            <td>
                                                @if($registration->event_registration_status_id == \App\Services\Common\Helpers\Event\EventRegistrationStatus\EventRegistrationStatusHelper::Confirmed->value)
                                                    <span
                                                        class="badge badge rounded-pill d-block p-2 badge-soft-success">
                                                {{ $registration->event_registration_status->name }}
                                                <span class="ms-1 fas fa-check" data-fa-transform="shrink-2"></span>
                                            </span>
                                                @elseif($registration->event_registration_status_id == \App\Services\Common\Helpers\Event\EventRegistrationStatus\EventRegistrationStatusHelper::AwaitingConfirmation->value)
                                                    <span
                                                        class="badge badge rounded-pill d-block p-2 badge-soft-warning">
                                                {{ $registration->event_registration_status->name }}
                                                <span class="ms-1 fas fa-stream" data-fa-transform="shrink-2"></span>
                                            </span>
                                                @else
                                                    <span
                                                        class="badge badge rounded-pill d-block p-2 badge-soft-secondary">
                                                {{ $registration->event_registration_status->name }}
                                                <span class="ms-1 fas fa-ban" data-fa-transform="shrink-2"></span>
                                            </span>
                                                @endif
                                            </td>
                                            <td>
                                                <div>
                                                    @if($registration->event_registration_status_id != \App\Services\Common\Helpers\Event\EventRegistrationStatus\EventRegistrationStatusHelper::Confirmed->value)
                                                        {{ Form::open(['url' => route('profile.events.registration.confirm', [$registration]), 'class' => 'd-inline']) }}
                                                        <button class="btn btn-link p-0" type="submit"
                                                                data-bs-toggle="tooltip"
                                                                data-bs-placement="top" title="Подтвердить">
                                                            <span class="text-500 fas fa-check"></span>
                                                        </button>
                                                        {{ Form::close() }}
                                                    @endif
                                                    @if($registration->event_registration_status_id != \App\Services\Common\Helpers\Event\EventRegistrationStatus\EventRegistrationStatusHelper::Canceled->value)
                                                        {{ Form::open(['url' => route('profile.events.registration.cancel', [$registration]), 'class' => 'd-inline']) }}
                                                        <button class="btn btn-link p-0 ms-2" type="submit"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="Отменить">
                                                            <span class="text-500 fas fa-times"></span>
                                                        </button>
                                                        {{ Form::close() }}
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    {{--
                                                                    <tr class="align-middle">
                                                                        <td class="text-nowrap">
                                                                            <div class="d-flex align-items-center">
                                                                                <div class="avatar avatar-xl">
                                                                                    <img class="rounded-circle" src="../../assets/img/team/4.jpg" alt=""/>
                                                                                </div>
                                                                                <div class="ms-2">Ricky Antony</div>
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-nowrap">ricky@example.com</td>
                                                                        <td class="text-nowrap">(201) 200-1851</td>
                                                                        <td class="text-nowrap">2392 Main Avenue, Penasauka</td>
                                                                        <td><span
                                                                                class="badge badge rounded-pill d-block p-2 badge-soft-success">Completed<span
                                                                                    class="ms-1 fas fa-check" data-fa-transform="shrink-2"></span></span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="align-middle">
                                                                        <td class="text-nowrap">
                                                                            <div class="d-flex align-items-center">
                                                                                <div class="avatar avatar-xl">
                                                                                    <img class="rounded-circle" src="../../assets/img/team/13.jpg" alt=""/>
                                                                                </div>
                                                                                <div class="ms-2">Emma Watson</div>
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-nowrap">emma@example.com</td>
                                                                        <td class="text-nowrap">(212) 228-8403</td>
                                                                        <td class="text-nowrap">2289 5th Avenue, New York</td>
                                                                        <td><span
                                                                                class="badge badge rounded-pill d-block p-2 badge-soft-success">Completed<span
                                                                                    class="ms-1 fas fa-check" data-fa-transform="shrink-2"></span></span>
                                                                        </td>
                                                                        <td class="text-end">$199</td>
                                                                    </tr>
                                                                    <tr class="align-middle">
                                                                        <td class="text-nowrap">
                                                                            <div class="d-flex align-items-center">
                                                                                <div class="avatar avatar-xl">
                                                                                    <div class="avatar-name rounded-circle"><span>RA</span></div>
                                                                                </div>
                                                                                <div class="ms-2">Rowen Atkinson</div>
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-nowrap">rown@example.com</td>
                                                                        <td class="text-nowrap">(201) 200-1851</td>
                                                                        <td class="text-nowrap">112 Bostwick Avenue, Jersey City</td>
                                                                        <td><span class="badge badge rounded-pill d-block p-2 badge-soft-primary">Processing<span
                                                                                    class="ms-1 fas fa-redo" data-fa-transform="shrink-2"></span></span>
                                                                        </td>
                                                                        <td class="text-end">$755</td>
                                                                    </tr>
                                                                    <tr class="align-middle">
                                                                        <td class="text-nowrap">
                                                                            <div class="d-flex align-items-center">
                                                                                <div class="avatar avatar-xl">
                                                                                    <img class="rounded-circle" src="../../assets/img/team/2.jpg" alt=""/>
                                                                                </div>
                                                                                <div class="ms-2">Antony Hopkins</div>
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-nowrap">antony@example.com</td>
                                                                        <td class="text-nowrap">(901) 324-3127</td>
                                                                        <td class="text-nowrap">3448 Ile De France St #242</td>
                                                                        <td><span
                                                                                class="badge badge rounded-pill d-block p-2 badge-soft-secondary">On Hold<span
                                                                                    class="ms-1 fas fa-ban" data-fa-transform="shrink-2"></span></span></td>
                                                                        <td class="text-end">$50</td>
                                                                    </tr>
                                                                    <tr class="align-middle">
                                                                        <td class="text-nowrap">
                                                                            <div class="d-flex align-items-center">
                                                                                <div class="avatar avatar-xl">
                                                                                    <img class="rounded-circle" src="../../assets/img/team/3.jpg" alt=""/>
                                                                                </div>
                                                                                <div class="ms-2">Jennifer Schramm</div>
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-nowrap">jennifer@example.com</td>
                                                                        <td class="text-nowrap">(828) 382-9631</td>
                                                                        <td class="text-nowrap">659 Hannah Street, Charlotte</td>
                                                                        <td>
                                                                            <span class="badge badge rounded-pill d-block p-2 badge-soft-warning">
                                                                                Pending
                                                                                <span class="ms-1 fas fa-stream" data-fa-transform="shrink-2"></span>
                                                                            </span>
                                                                        </td>
                                                                        <td class="text-end">$150</td>
                                                                    </tr>--}}
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card mb-3 mb-lg-0 mt-3">
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
                                {{ $event->country->name }}, {{ $event->city->name }} <br>
                                {{ $event->address }} <br>
                            </div>
                            <a href="#show_map">Посмотреть карту</a>
                        </div>
                    </div>
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
    </script>
@endsection
