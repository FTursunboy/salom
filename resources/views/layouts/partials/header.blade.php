<div class="bg-white">
    <div class="container">
        <nav class="navbar bg-white navbar-glass navbar-top navbar-expand">
            <a class="navbar-brand me-1 me-sm-3" href="{{ route('home') }}">
                <div class="d-flex align-items-center">
                    <span class="text-primary">salom</span>
                </div>
            </a>
            <ul class="navbar-nav navbar-nav-icons ms-auto flex-row align-items-center">

                <li class="nav-item dropdown me-2">
                    <a class="pe-0 ps-2 text-black fw-normal" id="navbarDropdownUser" role="button"
                       data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ cache('currentCity') }}  <i class="fas fa-chevron-down pt-1"></i>
                    </a>
                    <div class="dropdown-menu dropdown-caret dropdown-caret dropdown-menu-end py-0"
                         aria-labelledby="navbarDropdownUser">
                        <div class="bg-white dark__bg-1000 rounded-2 py-2">
                            <a class="dropdown-item" href="?city=all">Все города</a>
                            <div class="dropdown-divider"></div>
                            @foreach($cities as $city)
                                <a class="dropdown-item" href="?city={{ $city->name }}">{{ $city->name }}</a>
                            @endforeach
                        </div>
                    </div>
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
