<template id="event_schedule_template">
    <div class="border rounded-1 position-relative bg-white dark__bg-1100 p-3 mb-3" id="event_schedule_template">
        <div class="position-absolute end-0 top-0 mt-2 me-3 z-1">
            <button class="btn btn-link btn-sm p-0 event-schedule-btn" type="button" id="event_schedule_number">
                <span class="fas fa-times-circle text-danger" data-fa-transform="shrink-1">
                </span>
            </button>
        </div>
        <div class="row gx-2">
            <div class="col-12 mb-3">
                <label class="form-label" for="schedule-title">Название</label>
                <input class="form-control form-control-sm" id="event_schedule_title_template" type="text"
                       placeholder="Название">
            </div>
            <div class="col-sm-6 mb-3">
                <label class="form-label" for="schedule-start-date">Дата начала</label>
                <input class="form-control form-control-sm datetimepicker flatpickr-input"
                       id="event_schedule_start_date_template" type="text" placeholder="y-m-d"
                       data-options="{&quot;dateFormat&quot;:&quot;y-m-d&quot;,&quot;enableTime&quot;:false}"
                       required>
            </div>
            <div class="col-sm-6 mb-3">
                <label class="form-label" for="schedule-start-time">Время начала</label>
                <input class="form-control form-control-sm datetimepicker flatpickr-input"
                       id="event_schedule_start_time_template" type="text" placeholder="H:i"
                       data-options="{&quot;enableTime&quot;:true,&quot;noCalendar&quot;:true,&quot;dateFormat&quot;:&quot;H:i&quot;,&quot;time_24hr&quot;:true}"
                       readonly="readonly">
            </div>
            <div class="col-sm-6 mb-3 mb-sm-0">
                <label class="form-label" for="schedule-end-date">Дата окончания</label>
                <input class="form-control form-control-sm datetimepicker flatpickr-input"
                       id="event_schedule_end_date_template" type="text" placeholder="y-m-d"
                       data-options="{&quot;dateFormat&quot;:&quot;y-m-d&quot;,&quot;enableTime&quot;:false}"
                       readonly="readonly">
            </div>
            <div class="col-sm-6">
                <label class="form-label" for="schedule-end-time">Время окончания</label>
                <input class="form-control form-control-sm datetimepicker flatpickr-input"
                       id="event_schedule_end_time_template" type="text" placeholder="H:i"
                       data-options="{&quot;enableTime&quot;:true,&quot;noCalendar&quot;:true,&quot;dateFormat&quot;:&quot;H:i&quot;,&quot;time_24hr&quot;:true}"
                       readonly="readonly">
            </div>
        </div>
    </div>
</template>

<template id="add_phone_template">
    <div class="input-group mt-3" id="phones_group_template">
        {{ Form::text('phones[]', null, ['class' => 'form-control phones input-group-text bg-white', 'style' => 'text-align: left', 'placeholder' => 'Телефоны', 'id' => 'phones_template']) }}
        <button type="button" class="btn btn-sm d-flex flex-center transition-base input-group-text remove-phone" id="btn_phones_template" onclick="removePhone(this)">
            <i class="fas fa-minus"></i>
        </button>
    </div>
</template>

<template id="add_site_template">
    <div class="input-group mt-3" id="sites_group_template">
        {{ Form::text('sites[]', null, ['class' => 'form-control input-group-text bg-white', 'style' => 'text-align: left', 'placeholder' => 'Адрес сайта, аккаунта социальной сети, email', 'id' => 'sites_template']) }}
        <button type="button" class="btn btn-sm d-flex sites flex-center transition-base input-group-text" id="btn_sites_template" onclick="removeSite(this)">
            <i class="fas fa-minus"></i>
        </button>
    </div>
</template>
