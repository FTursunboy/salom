<div class="row g-0">

        @include('alert.errors')

        <div class="card cover-image mb-3">
            <img id="avatarImg" class="card-img-top" alt=""
                 src="{{ asset(old('photo', $event->photo ?? null) ? \App\Services\Common\Helpers\Image\ImageFolderHelper::TEMP_IMAGES_PATH . '/' . old('photo', $event->photo ?? null) : 'assets/img/no-photo.png') }}">
            {{ Form::hidden('photo', old('photo', $event->photo ?? null), ['id' => 'photo']) }}
            <input class="d-none" id="upload-cover-image" type="file">
            <label class="cover-image-file-input opacity-50" for="upload-cover-image">
                <span class="fas fa-camera me-2"></span>
                <span>Сменить фото обложки</span></label>
        </div>
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">Подробности о событии</h5>
            </div>
            <div class="card-body bg-body-tertiary">
                <div class="row gx-2">
                    <div class="col-12 mb-3">
                        <label class="form-label" for="event-name">Название события</label>
                        {{ Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Название события', 'required' => 'required']) }}
                    </div>
                    <div class="col-12 mb-0">
                        <label class="form-label" for="popular_place">Выберите место</label>
                        <select id="popular_place" class="form-control js-choice mb-0"
                                placeholder="Выберите место">
                            <option style="display: none"></option>
                            @foreach($popularPlaces as $item)
                                <option value="{{ $item->id }}"
                                        data-custom-properties="{{ $item->latitude . '#' . $item->longitude }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        {{ Form::hidden('latitude', null, ['id' => 'latitude']) }}
                        {{ Form::hidden('longitude', null, ['id' => 'longitude']) }}
                    </div>

                    <div class="col-12">
                        <div class="border-bottom border-dashed my-3"></div>
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="event-description">Описание</label>
                        {{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => '6', 'required' => 'required', 'placeholder' => 'Введите краткое описание, которое будет отображаться в анонсе события']) }}
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="event-text">Полное описание</label>
                        {{ Form::textarea('text', null, ['class' => 'form-control', 'placeholder' => 'Полное описание', 'id' => 'event-text']) }}
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Расписание</h5>
            </div>
            <div class="card-body bg-body-tertiary">
                <div id="event_schedules">
                    @php
                        $schedules = old('event_schedules', $event->schedules ?? ['']);
                    @endphp

                    @for($i = 0; $i < count($schedules); $i++)
                        @php
                            $item = [];
                            if (Route::is('profile.events.edit') && empty(old('event_schedules'))) {
                                $item = $schedules[$i]->toArray();
                            }
                        @endphp
                        <div class="border rounded-1 position-relative bg-white dark__bg-1100 p-3 mb-3"
                             id="event_schedule_{{ $i }}">
                            <div class="position-absolute end-0 top-0 mt-2 me-3 z-1">
                                <button class="btn btn-link btn-sm p-0 event-schedule-btn" data-number="{{ $i }}"
                                        type="button">
                                        <span class="fas fa-times-circle text-danger"
                                              data-fa-transform="shrink-1"></span>
                                </button>
                            </div>
                            <div class="row gx-2">
                                <div class="col-12 mb-3">
                                    <label class="form-label" for="schedule-title">Название</label>
                                    {{ Form::text("event_schedules[" . ($item['id'] ?? $i) . "][title]", $item['title'] ?? null,
                                    ['class' => 'form-control form-control-sm',]) }}
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label class="form-label" for="schedule-start-date">Дата начала</label>
                                    {{ Form::text("event_schedules[" . ($item['id'] ?? $i) . "][start_date]", $item['start_date'] ?? null,
                                    ['class' => 'form-control form-control-sm datetimepicker flatpickr-input', 'required' => 'required',
                                    'data-options' => '{&quot;dateFormat&quot;:&quot;Y-m-d&quot;,&quot;enableTime&quot;:false}']) }}
                                    {{--<input class="form-control form-control-sm datetimepicker flatpickr-input"
                                           type="text" placeholder="y-m-d"
                                           data-options="{&quot;dateFormat&quot;:&quot;y-m-d&quot;,&quot;enableTime&quot;:false}"
                                           required name="event_schedules[{{ $i }}][start_date]">--}}
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label class="form-label" for="schedule-start-time">Время начала</label>
                                    {{ Form::text("event_schedules[" . ($item['id'] ?? $i) . "][start_time]", $item['start_time'] ?? null,
                                                                        ['class' => 'form-control form-control-sm datetimepicker flatpickr-input', 'required' => 'required',
                                                                        'data-options' => '{&quot;enableTime&quot;:true,&quot;noCalendar&quot;:true,&quot;dateFormat&quot;:&quot;H:i&quot;,&quot;time_24hr&quot;:true}']) }}

                                    {{--<input class="form-control form-control-sm datetimepicker flatpickr-input"
                                           type="text" placeholder="H:i"
                                           data-options="{&quot;enableTime&quot;:true,&quot;noCalendar&quot;:true,&quot;dateFormat&quot;:&quot;H:i&quot;,&quot;time_24hr&quot;:true}"
                                           readonly="readonly" name="event_schedules[{{ $i }}][start_time]">--}}
                                </div>
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label class="form-label" for="schedule-end-date">Дата окончания</label>
                                    {{ Form::text("event_schedules[" . ($item['id'] ?? $i) . "][end_date]", $item['end_date'] ?? null,
                                    ['class' => 'form-control form-control-sm datetimepicker flatpickr-input', 'required' => 'required',
                                    'data-options' => '{&quot;dateFormat&quot;:&quot;Y-m-d&quot;,&quot;enableTime&quot;:false}']) }}
                                    {{--<input class="form-control form-control-sm datetimepicker flatpickr-input"
                                           type="text" placeholder="y-m-d"
                                           data-options="{&quot;dateFormat&quot;:&quot;Y-m-d&quot;,&quot;enableTime&quot;:false}"
                                           readonly="readonly" name="event_schedules[{{ $i }}][end_date]">--}}
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="schedule-end-time">Время окончания</label>
                                    {{ Form::text("event_schedules[" . ($item['id'] ?? $i) . "][end_time]", $item['end_time'] ?? null,
                                    ['class' => 'form-control form-control-sm datetimepicker flatpickr-input', 'required' => 'required',
                                    'data-options' => '{&quot;enableTime&quot;:true,&quot;noCalendar&quot;:true,&quot;dateFormat&quot;:&quot;H:i&quot;,&quot;time_24hr&quot;:true}']) }}
                                    {{--<input class="form-control form-control-sm datetimepicker flatpickr-input"
                                           type="text" placeholder="H:i"
                                           data-options="{&quot;enableTime&quot;:true,&quot;noCalendar&quot;:true,&quot;dateFormat&quot;:&quot;H:i&quot;,&quot;time_24hr&quot;:true}"
                                           readonly="readonly" name="event_schedules[{{ $i }}][end_time]">--}}
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
                <button class="btn btn-falcon-default btn-sm mt-2" type="button" id="add_event_schedule">
                    <span class="fas fa-plus fs--2 me-1" data-fa-transform="up-1"></span>
                    Добавить расписание
                </button>
            </div>
        </div>

        <div class="sticky-sidebar" style="top: 16px; margin-top: 10px">
            <div class="card mb-lg-0">
                <div class="card-header">
                    <h5 class="mb-0">Дополнительная информация</h5>
                </div>
                <div class="card-body bg-body-tertiary">
                    <div class="mb-3">
                        <label class="form-label" for="event-topic">Рубрика</label>
                        {!! Form::select('event_category_id', $eventCategories, null, ['class' => 'form-select', 'required' => 'required', 'placeholder' => 'Выберите рубрику']) !!}
                    </div>
                    <div class="border-bottom border-dashed my-3"></div>
                    <h6>Тип события</h6>
                    <div class="mb-3 form-check">
                        {{ Form::radio('event_type', 'free', true, ['class' => 'form-check-input', 'required' => 'required']) }}
                        <label class="form-label mb-0" for="customRadio4">
                            <strong>Бесплатное</strong>
                        </label>
                        <div class="form-text mt-0">
                            Здесь будеть описание
                        </div>
                    </div>
                    <div class="mb-3 form-check">
                        {{ Form::radio('event_type', 'paid', null, ['class' => 'form-check-input', 'required' => 'required']) }}
                        <label class="form-label mb-0" for="customRadio5">
                            <strong>Платное </strong></label>
                        <div class="form-text mt-0">
                            Оплата будет при входе или онлайн
                        </div>
                    </div>
                    <div class="mb-3 {{ (old('event_type', $event->event_type ?? null) == 'paid' ?: 'd-none') }}" id="ticket_amount">
                        <label class="form-label" for="tickets">Сумма билета (в сомони)</label>
                        {{ Form::number('ticket_amount', null, ['class' => 'form-control ']) }}
                    </div>
                    <div class="border-bottom border-dashed my-3"></div>
                    <div class="mb-3">
                        <label class="form-label" for="tickets">Оставшиеся билеты</label>
                        {{ Form::number('ticket_count', null, ['class' => 'form-control']) }}
                    </div>
                    <div class="form-check custom-checkbox mb-0">
                        {{ Form::checkbox('show_ticket_count', null, null, ['class' => 'form-check-input']) }}
                        <label class="form-label mb-0" for="customRadio6">
                            Показать количество оставшихся билетов.
                        </label>
                    </div>

                </div>
            </div>
            <div class="card mb-lg-0 mt-3">
                <div class="card-header">
                    <h5 class="mb-0">Контактная информация</h5>
                </div>
                <div class="card-body bg-body-tertiary">
                    <div class="mb-3">
                        <label class="form-label" for="tickets">Организатор</label>
                        {{ Form::text('organizer', null, ['class' => 'form-control']) }}
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="tickets">Телефоны</label>
                        <div id="phones">
                            <div class="input-group">
                                {{ Form::text('phones[0]', null, ['class' => 'form-control phones input-group-text bg-white', 'style' => 'text-align: left', 'placeholder' => 'Телефоны', 'data-number' => '0']) }}
                                <button type="button"
                                        class="btn btn-sm d-flex flex-center transition-base input-group-text"
                                        id="add_phone">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            @for($i = 1; $i < count($event->phones ?? []); $i++)
                                <div class="input-group mt-3" id="phones_group_{{ $i }}">
                                    {{ Form::text("phones[$i]", null, ['class' => 'form-control phones input-group-text bg-white', 'style' => 'text-align: left', 'placeholder' => 'Телефоны']) }}
                                    <button type="button" data-number="{{ $i }}"
                                            class="btn btn-sm d-flex flex-center transition-base input-group-text remove-phone"
                                            id="btn_phones_{{ $i }}" onclick="removePhone(this)">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            @endfor
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="tickets">Адрес сайта, аккаунта социальной сети, email</label>
                        <div id="sites">
                            <div class="input-group">
                                {{ Form::text('sites[0]', null, ['class' => 'form-control sites input-group-text bg-white', 'style' => 'text-align: left', 'placeholder' => 'Адрес сайта, аккаунта социальной сети, email', 'data-number' => '0']) }}
                                <button type="button"
                                        class="btn btn-sm d-flex flex-center transition-base input-group-text"
                                        id="add_site">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            @for($i = 1; $i < count($event->sites ?? []); $i++)
                                <div class="input-group mt-3" id="sites_group_{{ $i }}">
                                    {{ Form::text("sites[$i]", null, ['class' => 'form-control input-group-text bg-white', 'style' => 'text-align: left', 'placeholder' => 'Адрес сайта, аккаунта социальной сети, email']) }}
                                    <button type="button" data-number="{{ $i }}"
                                            class="btn btn-sm d-flex sites flex-center transition-base input-group-text"
                                            onclick="removeSite(this)">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


        <div class="card" style="margin-top: 15px">
            <div class="card-body">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md">
                        <h5 class="mb-2 mb-md-0">Хорошая работа! Вы почти закончили</h5>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-falcon-default btn-sm me-2">Сохранить</button>
                    </div>
                </div>
            </div>
        </div>


