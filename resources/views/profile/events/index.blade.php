@extends('layouts.main')

@section('content')

    @include('layouts.partials.profile_header')

    <div class="container mt-3">
        <div class="card mb-3 mb-lg-0">
            <div class="card-header bg-body-tertiary d-flex justify-content-between">
                <h5 class="mb-0">Мои события</h5>
                <a class="btn btn-primary font-sans-serif" href="{{ route('profile.events.create') }}">Добавить</a>
            </div>
            <div class="card-body fs--1">

                @if($events->count() == 0)
                    <div class="py-5 fw-bold text-900 text-center fs-2">
                        У вас еще нет событий
                    </div>
                @endif

                @foreach($events as $event)
                    <div class="row btn-reveal-trigger">
                        <div class="col-md-2 col-sm-12">
                            <img src="{{ asset($event->thumb_photo_path) }}" alt=""
                                 class="img-fluid object-fit-cover w-sm-100 rounded-1 absolute-sm-centered">
                        </div>
                        <div class="col-md-7 col-sm-12 position-relative ps-3"  >
                            <h6 class="fs-0 mb-0 py-3 py-sm-0">
                                <a href="{{ route('events.show', $event) }}">{{ $event->title }}</a>
                            </h6>
                            <p class="mb-1 webkit-line-3">{{ $event->description }}</p>
                            <p class="text-1000 mb-0">Статус: {{ $event->event_status->name }}</p>
                            Адрес: {{ $event->address }}
                        </div>
                        <div class="col-md-3 col-sm-12 d-flex justify-content-between flex-column">
                            <div>
                                <div class="d-none d-lg-block">
                                    <p class="fs--1 mb-1">Кол-во просмотров: <strong>{{ $event->view_count }}</strong></p>
                                    <p class="fs--1 mb-1">Кол-во зарег. поль: <strong>{{ $event->registered_users }}</strong></p>
                                </div>
                            </div>
                            <div class="mt-2">
                                <a class="btn btn-sm btn-outline-secondary border-300 d-lg-block me-2 me-lg-0 col-12"
                                   href="{{ route('profile.events.edit', $event) }}">
                                    <i class="fas fa-pencil-alt"></i>
                                    <span class="ms-2">Редактировать</span>
                                </a>
                                <a class="btn btn-sm btn-primary d-lg-block mt-lg-2 col-12 mt-2" href="{{ route('events.show', $event) }}">
                                    <i class="fas fa-eye"></i>
                                    <span class="ms-2">Посмотреть</span>
                                </a>
                                {{ Form::open(['url' => route('profile.events.destroy', $event), 'method' => 'delete', 'onsubmit' => 'return confirm("Вы действительно хотите удалить события?")']) }}
                                <button type="submit" class="btn btn-sm btn-primary mt-lg-2 col-12 mt-2">
                                    <i class="fas fa-trash"></i>
                                    <span class="ms-2">Удалить</span>
                                </button>
                                {{ Form::close() }}
                            </div>
                        </div>
                        <div class="border-bottom border-dashed my-3"></div>
                    </div>
                @endforeach
            </div>
            {{--<div class="card-footer bg-body-tertiary p-0 border-top">
                <a class="btn btn-link d-block w-100" href="../../app/events/event-list.html">All Events
                    <span class="fas fa-chevron-right ms-1 fs--2"></span>
                </a>
            </div>--}}
        </div>
    </div>

@endsection

@section('styles')
    <style>
        .webkit-line-3 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
        }
    </style>
@endsection
