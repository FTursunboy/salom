@extends('layouts.main')

@section('main-class', 'bg-white')

@section('content')
    <div class="container">
        <div class="col-12" style="margin-top: 20px">
            <h5 style=" font-size: 18px; font-weight: bold; margin-bottom: 18px ">Календарь событий Душанбе</h5>
            <p style="font-size: 12.5px; color: black; margin-top: -10px; line-height: 16px;">Выбрав конкретный день или период вы сможете
                увидеть все события, вечеринки, концерты, рестораны, <br> выставки, кино и многое другое</p>
        </div>
        <div class="col-12">
            <nav class="focus-cat-list" id="calendar-widget">
                <div class="d-flex wrapper mt-lg-5 pb-lg-4 font-family-montserrat" id="calendar">
                    <div>
                        <div class="d-flex">
                            @for($i = 0; $i < $countDaysEvents; $i++)
                                @if($i == 0 || \Carbon\Carbon::now()->addDays($i)->day == 1)
                        </div>
                    </div>
                    <div>
                                        <p class="calendar-custom-month-name me-5"
                                              style="color: black;  margin-top: 10px">
                                            {{ $months[\Carbon\Carbon::now()->addDays($i)->month - 1] }}
                                        </p>
                        <div class="d-flex">
                            @endif
                            @php
                                $date = \Carbon\Carbon::now()->addDays($i);
                                $class = '';
                                $calendarActiveClass = '';
                                $active = $eventDaysActive[$date->toDateString()] ?? false;
                                if ($i == 0 && empty($requestDate) || ($requestDate == $date->format('Y-m-d'))) {
                                    $calendarActiveClass .= 'calendar-custom-active ';
                                }
                                if(\Carbon\Carbon::now()->addDays($i)->endOfMonth()->toDateString() == $date->toDateString()) {
                                    $class = ' me-5';
                                }
                                if ($active) {
                                    $calendarActiveClass .= 'calendar-custom-hover';
                                } else {
                                    $calendarActiveClass .= 'opacity-50';
                                }
                            @endphp
                            <a @if($active) href="?date={{ $date->format('Y-m-d') }}" @endif
                            class="text-black text-decoration-none {{ $class }}">
                                <div class="calendar-custom {{ $calendarActiveClass }}">
                                        <span class="calendar-custom-month">
                                            {{ $weeks[$date->format('w')] }}
                                        </span>
                                    <span class="calendar-custom-day">
                                            {{ $date->day }}
                                        </span>
                                </div>
                            </a>
                            @endfor
                        </div>
                    </div>

                </div>
            </nav>

        </div>

        @foreach($eventCategories as $eventCategory)
            <div class="col-12">
                <div class="col-12 mt-4 mb-4">
                    <h5 class="mb-0" style="font-weight: bold">{{ $eventCategory->name }}
                        <span class="fw-normal fs-lg--1 text-secondary">
                            @if($requestDate == \Carbon\Carbon::now()->format('Y-m-d'))
                                сегодня
                            @elseif($requestDate == \Carbon\Carbon::now()->addDays(1)->format('Y-m-d'))
                                завтра
                            @else
                                {{ \Carbon\Carbon::parse($requestDate)->translatedFormat('D, d M') }}
                            @endif
                        </span>
                    </h5>
                </div>
                <div class="row">
                    @foreach($eventCategory->custom_events as $event)

                        <div id="img" class="col-4">
                            <a class="d-block w-100"
                               href="{{ route('events.show', $event)  }}">
                                <img style="border-radius: 15px; margin-top: -10px; height: 230px"
                                    class="img-fluid object-fit-cover w-sm-100 h-sm-100 w-100 absolute-sm-centered"
                                    src="{{ $event->thumb_photo_path }}" alt="">
                            </a>
                        </div>

                        <div class="col-12">
                                <h3 style="font-weight: bold" class="text-1100 fs-0 fs-lg-1  mt-3" href="{{ route('events.show', $event) }}">
                                    {{ $event->title }}
                                </h3>

                            <p class="col-12">
                                @if($event->free_entrance == false)
                                    Бесплатно,
                                @endif
                                @if($event->start_date != $event->end_date)
                                    с {{ $event->start_date->day }}
                                    @if($event->end_date->month != $event->start_date->month)
                                        {{ $monthWithSuffixes[$event->start_date->month - 1] }}
                                    @endif
                                    по
                                @endif
                                {{ $event->end_date->day }} {{ $monthWithSuffixes[$event->end_date->month - 1] }}, {{$event->popularPlace?->name}}
                            </p>

                        </div>

                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
@endsection

@section('styles')
    <style>
        .left-0 {
            left: 0;
        }
    </style>
@endsection

@section('scripts')
    <script>
        function updateColumnClass() {
            const imgDiv = document.getElementById('img');
            const windowWidth = window.innerWidth;

            if (windowWidth >= 992) {
                if (imgDiv.classList.contains('col-12')) {
                    imgDiv.classList.remove('col-12');
                    imgDiv.classList.add('col-4');
                }
            } else {
                if (imgDiv.classList.contains('col-4')) {
                    imgDiv.classList.remove('col-4');
                    imgDiv.classList.add('col-12');
                }
            }
        }

        // Вызываем функцию при загрузке страницы и при изменении размера окна
        window.addEventListener('load', updateColumnClass);
        window.addEventListener('resize', updateColumnClass);
        $('.focus-cat-list .next').click(function () {
            var pos = $('.focus-cat-list .wrapper').scrollLeft() + 330;

            $('.focus-cat-list .wrapper').stop().animate({scrollLeft: pos}, 500, 'swing', function () {
                checkPosition();
            });
        });

        $('.focus-cat-list .previous').click(function () {
            var pos = $('.focus-cat-list .wrapper').scrollLeft() - 330;

            $('.focus-cat-list .wrapper').stop().animate({scrollLeft: pos}, 500, 'swing', function () {
                checkPosition();
            });
        });

        $("#calendar").scroll(function () {
            checkPosition();
        });

        function checkPosition() {
            let calendar = $('.calendar-custom');
            let first = calendar.eq(0).position().left;
            let previous = $('.previous').position().left;

            let last = calendar.eq(calendar.length - 1).position().left;
            let next = $('.next').position().left;

            console.log(first, previous, last, next);

            if (first >= -20) {
                $('.previous').css('display', 'none');

                console.log(document.getElementsByClassName('calendar-custom-month-name').length);
                let elements = document.getElementsByClassName('calendar-custom-month-name');
                elements.forEach(function (el) {
                    el.classList.add('left-0');
                });
            } else {
                $('.previous').css('display', 'inline-block');
                document.getElementsByClassName('calendar-custom-month-name').forEach(function (el) {
                    el.classList.remove('left-0');
                });
            }

            if (last <= next + 20) {
                $('.next').css('display', 'none');
            } else {
                $('.next').css('display', 'inline-block');
            }
        }

        checkPosition();
    </script>
@endsection
