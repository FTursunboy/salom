<div class="bg-white">
    <div class="container" style="border-bottom: 1px solid grey; height: 65px">
        <nav class="navbar bg-white navbar-expand-lg navbar-light">
            <a class="navbar-brand me-1 me-sm-3" href="{{ route('home') }}">
                <img style="margin-top: 10px" height="35px" width="130px" src="{{asset('anons.png')}}" alt="Anons Logo">
            </a>
            <a class="navbar-toggler" type="button"  href="{{ route('profile.events.create') }}"   aria-label="Toggle navigation">
                <span class="custom-toggler-icon"></span>
            </a>


            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a id="eventB" class="btn btn-border btn-listing postadd" href="{{ route('profile.events.create') }}">
                            Разместить событие
                        </a>
                    </li>
                    @if(auth()->user())
                        @include('layouts.partials.navbar_dropdown')
                    @else
                        <li class="nav-item">
                            <a id="loginB" href="{{ route('login') }}">Войти</a>
                        </li>
                    @endif
                </ul>
            </div>
        </nav>
    </div>
</div>
