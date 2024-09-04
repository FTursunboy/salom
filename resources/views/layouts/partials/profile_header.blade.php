<div class="container">
    <nav class="navbar navbar-expand navbar-light justify-content-center text-nowrap p-0 d-none d-md-flex">
        <ul class="navbar-nav py-2 gap-4" style="overflow-x: auto">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('profile.index') }}">Профиль</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('profile.setting') }}">Настройки профиля</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('tickets.index') }}">Мои билеты</a>
            </li>
{{--            <li class="nav-item">--}}
{{--                <a class="nav-link" href="{{ route('profile.favorite.index') }}">Избранное</a>--}}
{{--            </li>--}}
            <li class="nav-item">
                <a class="nav-link" href="{{ route('profile.events.index') }}">Мои события</a>
            </li>
        </ul>
    </nav>
</div>
