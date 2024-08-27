<li class="nav-item dropdown">
    <a class="nav-link pe-0 ps-2" id="navbarDropdownUser" role="button"
       data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <div class="avatar avatar-xl">
            <img class="rounded-circle" src="{{ asset(auth()->user()->photo_path) }}" alt="">
        </div>
    </a>
    <div class="dropdown-menu dropdown-caret dropdown-caret dropdown-menu-end py-0"
         aria-labelledby="navbarDropdownUser">
        <div class="bg-white dark__bg-1000 rounded-2 py-2">
                            <span class="dropdown-item-text">
                                <span class="fw-normal text-black">{{ auth()->user()->first_name }}</span>
                            </span>
            <div class="dropdown-divider"></div>
            @if(auth()->user()->is_admin)
                <a class="dropdown-item" href="{{ route('admin.dashboard') }}">Админ панель</a>
                <div class="dropdown-divider"></div>
            @endif
            <a class="dropdown-item" href="{{ route('profile.index') }}">Профиль</a>
            <a class="dropdown-item" href="{{ route('profile.setting') }}">Настройки профиля</a>
            <a class="dropdown-item" href="{{ route('tickets.index') }}">Мои билеты</a>
            <a class="dropdown-item" href="{{ route('profile.favorite.index') }}">Избранное</a>
            <a class="dropdown-item" href="{{ route('profile.events.index') }}">Мои события</a>
            <a class="dropdown-item" href="{{ route('profile.events.create') }}">Добавить события</a>
            <div class="dropdown-divider"></div>
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button class="dropdown-item" href="{{ route('logout') }}">Выйти</button>
            </form>
        </div>
    </div>
</li>
