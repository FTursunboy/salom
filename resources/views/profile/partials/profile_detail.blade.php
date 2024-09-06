<div class="py-4">
    <div class="container">
        <div class="row">
            @include('alert.errors')
            @include('alert.success')

            <div class="col-lg-12">
                <div class="card mb-3 btn-reveal-trigger">
                    <div class="card-header position-relative min-vh-25 mb-7">
                        <div class="cover-image">
                            <div id="backgroundImage" class="bg-holder rounded-3 rounded-bottom-0"
                                 style="background-image:url({{ asset($user->background_image_path) }});"></div>
                        </div>
                        <div class="avatar avatar-5xl avatar-profile shadow-sm img-thumbnail rounded-circle">
                            <div id="photo" class="h-100 w-100 rounded-circle overflow-hidden position-relative">
                                <img id="profileImage" src="{{ asset($user->photo_path) }}" width="200"
                                     alt="" data-dz-thumbnail="data-dz-thumbnail">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-8">
                                <h4 class="mb-1"> {{ $user->full_name }}
                                    @if($user->is_verified)
                                        <span data-bs-toggle="tooltip" data-bs-placement="right"
                                              aria-label="Verified" data-bs-original-title="Проверено">
                                            <small class="fa fa-check-circle text-primary"
                                                   data-fa-transform="shrink-4 down-2"></small>
                                        </span>
                                    @endif
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="card mb-3">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">О себе</h5>
                    </div>
                    <div class="card-body text-justify">
                        @if($user->description)
                            <p class="mb-0 text-1000">
                                {{ $user->description }}
                            </p>
                        @else
                            <div class="text-center pt-4 pb-3">
                                Пользователь еще не поделился информацией о себе
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-0">Событии</h5>
                    </div>
                    <div class="card-body fs--1">
                        @if($events->count() == 0)
                            <div class="text-center pt-3 pb-5">
                                У пользователя еще нет событий
                            </div>
                        @endif
                        @foreach($events as $event)
                            <div class="row">
                                <div class="col-3 pe-0">
                                    <img src="{{ asset($event->thumb_photo_path) }}" class="w-100" alt="">
                                </div>
                                <div class="col-9 ps-3">
                                    <h6 class="fs-0 mb-0">
                                        <a href="{{ route('events.show', $event) }}">{{ $event->title }}</a>
                                    </h6>
                                    <p class="mb-1">Организатор:
                                        <a href="{{ route('profile.show', $user) }}"
                                           class="text-700">{{ $event->created_by->full_name }}</a>
                                    </p>
                                    <p class="text-1000 mb-0">Заинтересованных людей: {{ $event->view_count }}</p>
                                    Место: {{ $event->address }}
                                    <div class="border-bottom border-dashed my-3"></div>
                                </div>
                            </div>
                        @endforeach
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
