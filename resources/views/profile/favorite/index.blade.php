@extends('layouts.main')

@section('content')

    @include('layouts.partials.profile_header')

    <div class="container mt-3">
        <div class="card mb-3 mb-lg-0">
            <div class="card-header bg-body-tertiary d-flex justify-content-between">
                <h5 class="mb-0">Избранное</h5>
            </div>
            <div class="card-body fs--1">

                @if($favorites->count() == 0)
                    <div class="py-5 fw-bold text-900 text-center fs-2">
                        У вас еще нет избранных событий
                    </div>
                @endif

                @foreach($favorites as $item)
                    <div class="row btn-reveal-trigger">
                        <div class="col-md-2">
                            <img src="{{ asset($item->event->thumb_photo_path) }}" alt=""
                                 class="img-fluid object-fit-cover w-sm-100 rounded-1 absolute-sm-centered">
                        </div>
                        <div class="col-md-10 position-relative ps-3">
                            <h6 class="fs-0 mb-0 py-3 py-sm-0">
                                <a href="{{ route('events.show', $item->event) }}">{{ $item->event->title }}</a>
                            </h6>
                            <p class="mb-1 webkit-line-3">{{ $item->event->description }}</p>
                            Адрес: {{ $item->event->address }}
                        </div>
                        <div class="border-bottom border-dashed my-3"></div>
                    </div>
                @endforeach
            </div>
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
