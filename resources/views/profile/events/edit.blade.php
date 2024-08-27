@extends('layouts.main')

@section('content')

    @include('layouts.partials.profile_header')

    <div class="container mt-3 pb-3">

        {!! Form::model($event, ['url' => route('profile.events.update', $event), 'method' => 'put', 'onsubmit' => 'return validateFormBeforeSubmit(this)']) !!}
            @include('profile.events.partials.fields')
        {!! Form::close() !!}

    </div>

    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Обрезка изображения перед загрузкой</h5>
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="img-container">
                        <div class="row">
                            <div class="col-md-8">
                                <img src="" id="sample_image"/>
                            </div>
                            <div class="col-md-4">
                                <div class="preview"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="crop" class="btn btn-primary" >Обрезать</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                </div>
            </div>
        </div>
    </div>

    @include('profile.events.partials.template')

@endsection

@section('styles')
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
{{--    <link rel="stylesheet" href="https://unpkg.com/dropzone/dist/dropzone.css"/>--}}
    <link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet"/>
{{--    <script src="https://unpkg.com/dropzone"></script>--}}
    <script src="https://unpkg.com/cropperjs"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/styles/choices.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/scripts/choices.min.js"></script>

    <style>
        .ck-content {
            min-height: 300px;
        }

        #map {
            width: 100%;
            height: 400px;
        }

        .header {
            padding: 5px;
        }
    </style>
    @include('profile.events.partials.styles')
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&amp;apikey=34e10fe7-9e6e-49d4-8a31-084a2fef9737"
            type="text/javascript"></script>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/flatpickr.js') }}"></script>
    <script src="https://unpkg.com/imask"></script>
    @include('profile.events.partials.scripts')
@endsection
