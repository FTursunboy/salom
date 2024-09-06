@extends('layouts.main')

@section('content')

    @include('layouts.partials.profile_header')

    <div class="py-4">
        <div class="container">
            <div class="row">
                @include('alert.errors')
                @include('alert.success')

                <div class="col-lg-8">
                    <div class="card mb-3 btn-reveal-trigger">
                        <div class="card-header position-relative min-vh-25 mb-8">
                            <div class="cover-image">
                                <div id="backgroundImage" class="bg-holder rounded-3 rounded-bottom-0"
                                     style="background-image:url({{ asset(auth()->user()->background_image_path) }});"></div>

                                <input class="d-none" id="upload-cover-image" type="file">
                                <label class="cover-image-file-input opacity-50" for="upload-cover-image">
                                    <span class="fas fa-camera me-2"></span>
                                    <span>Сменить фото обложки</span>
                                </label>
                            </div>
                            <div class="avatar avatar-5xl avatar-profile shadow-sm img-thumbnail rounded-circle">
                                <div id="photo" class="h-100 w-100 rounded-circle overflow-hidden position-relative">
                                    <img id="profileImage" src="{{ asset(auth()->user()->photo_path) }}" width="200"
                                         alt="" data-dz-thumbnail="data-dz-thumbnail">
                                    <input class="d-none" id="profile-image" type="file">

                                    <label class="mb-0 overlay-icon d-flex flex-center" for="profile-image">
                                        <span class="bg-holder overlay overlay-0"></span>
                                        <span class="z-index-1 text-white dark__text-white text-center fs--1">
                                            <span class="fas fa-camera"></span>
                                            <span class="d-block">Обновить</span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="mb-0">Настройки профиля</h5>
                        </div>
                        <div class="card-body bg-light">
                            {{ Form::model(auth()->user(), ['url' => route('profile.update'), 'class' => 'row g-3', 'method' => 'put']) }}
                            <div class="col-lg-6">
                                <label class="form-label" for="first-name">Имя</label>
                                {{ Form::text('first_name', null, ['class' => 'form-control']) }}
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label" for="last-name">Фамилия</label>
                                {{ Form::text('last_name', null, ['class' => 'form-control']) }}
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label" for="email1">Email</label>
                                {{ Form::email('email', null, ['class' => 'form-control']) }}
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label" for="email2">Номер телефон</label>
                                {{ Form::text('phone_formatted', auth()->user()->phone_formatted, ['class' => 'form-control', 'disabled']) }}
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label" for="email2">Дата рождения</label>
                                {{ Form::text("birth_date", null, ['class' => 'form-control datetimepicker flatpickr-input',
                                    'data-options' => '{&quot;dateFormat&quot;:&quot;Y-m-d&quot;,&quot;enableTime&quot;:false}']) }}
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label" for="email2">Телеграм</label>
                                {{ Form::text('telegram', null, ['class' => 'form-control']) }}
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label" for="email2">Пол</label>
                                {{ Form::select('gender', trans('common.gender'), null, ['class' => 'form-control', 'id' => 'phone']) }}
                            </div>
                            <div class="col-lg-12">
                                <label class="form-label" for="intro">О себе</label>
                                {{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => '6', 'placeholder' => '']) }}
                            </div>

                            <div class="col-12 d-flex justify-content-end">
                                {{ Form::submit('Сохранить', ['class' => 'btn btn-primary']) }}
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="mb-0">Изменить пароль</h5>
                        </div>
                        <div class="card-body bg-light">
                            {{ Form::open(['url' => route('password.update'), 'method' => 'put']) }}
                            <div class="mb-3">
                                <label class="form-label" for="old-password">Старый пароль</label>
                                {{ Form::password('current_password', ['class' => 'form-control']) }}
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="new-password">Новый пароль</label>
                                {{ Form::password('password', ['class' => 'form-control']) }}
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="confirm-password">Подтвердите пароль</label>
                                {{ Form::password('password_confirmation', ['class' => 'form-control']) }}
                            </div>
                            {{ Form::submit('Обновить пароль', ['class' => 'btn btn-primary d-block w-100']) }}
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Обрезка изображения перед загрузкой</h5>
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                            data-bs-dismiss="modal" aria-label="Close"></button>
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
                    <button type="button" id="crop" class="btn btn-primary">Обрезать</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('styles')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet"/>
    <script src="https://unpkg.com/cropperjs"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/styles/choices.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/scripts/choices.min.js"></script>

    <style>
        .cropper-crop-box, .cropper-container {
            max-width: 100%;
        }

        .image_area {
            position: relative;
        }

        img {
            display: block;
            max-width: 100%;
        }

        .preview {
            overflow: hidden;
            width: 160px;
            height: 160px;
            margin: 10px;
            border: 1px solid red;
        }

        .modal-lg {
            max-width: 1000px !important;
        }

        .overlay {
            position: absolute;
            bottom: 10px;
            left: 0;
            right: 0;
            background-color: rgba(255, 255, 255, 0.5);
            overflow: hidden;
            height: 0;
            transition: .5s ease;
            width: 100%;
        }

        .image_area:hover .overlay {
            height: 50%;
            cursor: pointer;
        }
    </style>

@endsection

@section('scripts')
    <script src="{{ asset('assets/js/flatpickr.js') }}"></script>
{{--    <script src="https://unpkg.com/imask"></script>--}}
    @include('profile.partials.scripts')
@endsection
