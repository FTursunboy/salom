<div class="bg-white">
    <div class="container">
        <nav class="navbar bg-white navbar-glass navbar-top navbar-expand">
            <a class="navbar-brand me-1 me-sm-3" href="{{ route('home') }}">
                <div class="d-flex align-items-center">
                    <div>
                        <img style="margin-top: 10px" width="110px" src="{{asset('anons.png')}}" alt="">
                    </div>
                </div>
            </a>
            <ul class="navbar-nav navbar-nav-icons ms-auto flex-row align-items-center">


                <li class="nav-item postadd">
                    <a class="btn btn-border btn-listing"
                       href="{{ route('profile.events.create') }}">
                        Разместить событие
                    </a>
                </li>
                @if(auth()->user())
                    @include('layouts.partials.navbar_dropdown')
                @else
                    <li class="nav-item dropdown px-1">
                        <a class="btn btn-outline-primary" href="{{ route('login') }}">Войти</a>
                    </li>
                @endif

            </ul>
        </nav>
    </div>

</div>
