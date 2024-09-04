<!DOCTYPE html>
<html data-bs-theme="light" lang="en-US" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- ===============================================--><!--    Document Title-->
    <!-- ===============================================-->
    <title>@section('title')
            anons | Сервис по поиску впечатлений
        @show</title>

    <!-- ===============================================--><!--    Favicons-->
    <!-- ===============================================-->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.png') }}">
    <meta name="msapplication-TileImage" content="{{ asset('assets/img/logo.png') }}">
    <meta name="theme-color" content="# ">
    <script src="{{ asset('assets/js/config.js') }}"></script>
    <script src="{{ asset('vendors/simplebar/simplebar.min.js') }}"></script>

    <!-- ===============================================--><!--    Stylesheets-->
    <!-- ===============================================-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap"
        rel="stylesheet">
    <link href="{{ asset('vendors/simplebar/simplebar.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/dropzone/dropzone.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/theme-rtl.css') }}" rel="stylesheet" id="style-rtl">
    <link href="{{ asset('assets/css/theme.css') }}" rel="stylesheet" id="style-default">
    <link href="{{ asset('assets/css/user-rtl.css') }}" rel="stylesheet" id="user-style-rtl">
    <link href="{{ asset('assets/css/user.css') }}" rel="stylesheet" id="user-style-default">
    <link rel="stylesheet" type="text/css" href="https://rawgit.com/vitmalina/w2ui/master/dist/w2ui.min.css">
    <script>
        var isRTL = JSON.parse(localStorage.getItem('isRTL'));
        if (isRTL) {
            var linkDefault = document.getElementById('style-default');
            var userLinkDefault = document.getElementById('user-style-default');
            linkDefault.setAttribute('disabled', true);
            userLinkDefault.setAttribute('disabled', true);
            document.querySelector('html').setAttribute('dir', 'rtl');
        } else {
            var linkRTL = document.getElementById('style-rtl');
            var userLinkRTL = document.getElementById('user-style-rtl');
            linkRTL.setAttribute('disabled', true);
            userLinkRTL.setAttribute('disabled', true);
        }
    </script>
    @yield('styles')
</head>

<body>
<!-- ===============================================--><!--    Main Content-->
<!-- ===============================================-->
<main class="main @yield('main-class')" id="top">

    <div class="container" data-layout="container">
        <script>
            var isFluid = JSON.parse(localStorage.getItem('isFluid'));
            if (isFluid) {
                var container = document.querySelector('[data-layout]');
                container.classList.remove('container');
                container.classList.add('container-fluid');
            }
        </script>

        <nav class="navbar navbar-light navbar-vertical navbar-expand-xl" style="display: none;">
            <script>
                var navbarStyle = localStorage.getItem("navbarStyle");
                if (navbarStyle && navbarStyle !== 'transparent') {
                    document.querySelector('.navbar-vertical').classList.add(`navbar-${navbarStyle}`);
                }
            </script>
            <div class="d-flex align-items-center">
                <div class="toggle-icon-wrapper">
                    <button class="btn navbar-toggler-humburger-icon navbar-vertical-toggle" data-bs-toggle="tooltip"
                            data-bs-placement="left" title="Toggle Navigation">
                        <span class="navbar-toggle-icon">
                            <span class="toggle-line"></span>
                        </span>
                    </button>
                </div>
                <a class="navbar-brand" href="{{ route('home') }}">
                    <div class="d-flex align-items-center py-3">
                        anons
                    </div>
                </a>
            </div>
            <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
                <div class="navbar-vertical-content scrollbar">
                    <ul class="navbar-nav flex-column mb-3" id="navbarVerticalNav">
                        <li class="nav-item">
                            <!-- parent pages-->
                            <a class="nav-link" href="{{ route('admin.dashboard') }}" role="button">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-icon">
                                        <span class="fas fa-chart-pie"></span>
                                    </span>
                                    <span class="nav-link-text ps-1">Dashboard</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <!-- label-->
                            <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                                <div class="col-auto navbar-vertical-label">Пользователи</div>
                                <div class="col ps-0">
                                    <hr class="mb-0 navbar-vertical-divider"/>
                                </div>
                            </div>
                            <!-- parent pages-->
                            <a class="nav-link" href="{{ route('admin.users.index') }}" role="button">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-icon">
                                        <span class="fas fa-users"></span>
                                    </span>
                                    <span class="nav-link-text ps-1">Пользователи</span>
                                </div>
                            </a>
                        </li>

                        <li class="nav-item">
                            <!-- label-->
                            <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                                <div class="col-auto navbar-vertical-label">События</div>
                                <div class="col ps-0">
                                    <hr class="mb-0 navbar-vertical-divider"/>
                                </div>
                            </div>
                            <!-- parent pages-->
                            <a class="nav-link" href="{{ route('admin.events.index') }}" role="button">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-icon">
                                        <span class="far fa-calendar-check"></span>
                                    </span>
                                    <span class="nav-link-text ps-1">События</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <nav class="navbar navbar-light navbar-glass navbar-top navbar-expand-lg" style="display: none;">
            <button class="btn navbar-toggler-humburger-icon navbar-toggler me-1 me-sm-3" type="button"
                    data-bs-toggle="collapse" data-bs-target="#navbarStandard" aria-controls="navbarStandard"
                    aria-expanded="false" aria-label="Toggle Navigation">
                <span class="navbar-toggle-icon">
                    <span class="toggle-line"></span>
                </span>
            </button>
            <a class="navbar-brand me-1 me-sm-3" href="{{ route('home') }}">
                <div class="d-flex align-items-center">
                    anons
                </div>
            </a>
        </nav>
        <div class="content">
            <nav class="navbar navbar-light navbar-glass navbar-top navbar-expand-lg" style="display: none;"
                 data-move-target="#navbarVerticalNav" data-navbar-top="combo">
                <ul class="navbar-nav navbar-nav-icons ms-auto flex-row align-items-center">

                    <li class="nav-item dropdown me-2">
                        <a class="pe-0 ps-2 text-black fw-normal" id="navbarDropdownUser" role="button"
                           data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Душанбе <i class="fas fa-chevron-down pt-1"></i>
                        </a>
                        <div class="dropdown-menu dropdown-caret dropdown-caret dropdown-menu-end py-0"
                             aria-labelledby="navbarDropdownUser">
                            <div class="bg-white dark__bg-1000 rounded-2 py-2">
                                <a class="dropdown-item" href="">Все города</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="">Душанбе</a>
                                <a class="dropdown-item" href="">Худжанд</a>
                                <a class="dropdown-item" href="">Бохтар</a>
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
            <script>
                var navbarPosition = localStorage.getItem('navbarPosition');
                var navbarVertical = document.querySelector('.navbar-vertical');
                var navbarTopVertical = document.querySelector('.content .navbar-top');
                var navbarTop = document.querySelector('[data-layout] .navbar-top:not([data-double-top-nav])');
                var navbarDoubleTop = document.querySelector('[data-double-top-nav]');
                var navbarTopCombo = document.querySelector('.content [data-navbar-top="combo"]');

                if (localStorage.getItem('navbarPosition') === 'double-top') {
                    document.documentElement.classList.toggle('double-top-nav-layout');
                }

                console.log(navbarPosition);

                navbarVertical.removeAttribute('style');
                navbarTopVertical.removeAttribute('style');
                navbarTop.remove(navbarTop);
                navbarDoubleTop.remove(navbarDoubleTop);
                navbarTopCombo.remove(navbarTopCombo);
            </script>

            @yield('content')

            <footer class="footer">
                <div class="row g-0 justify-content-between fs--1 mt-4 mb-3">
                    <div class="col-12 col-sm-auto text-center">
                        <p class="mb-0 text-600">Все права защищены
                            <span class="d-none d-sm-inline-block">| </span>
                            <br class="d-sm-none"/> {{ \Carbon\Carbon::now()->year }} &copy;
                            <a href="{{ route('home') }}">anons</a>
                        </p>
                    </div>
                    <div class="col-12 col-sm-auto text-center">
                        <p class="mb-0 text-600">v1.0.0</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>

</main>

    <!-- ===============================================--><!--    JavaScripts-->
    <!-- ===============================================-->
    <script src="{{ asset('vendors/popper/popper.min.js') }}"></script>
    <script src="{{ asset('vendors/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendors/anchorjs/anchor.min.js') }}"></script>
    <script src="{{ asset('vendors/is/is.min.js') }}"></script>
    <script src="{{ asset('vendors/dropzone/dropzone.min.js') }}"></script>
    <script src="{{ asset('vendors/fontawesome/all.min.js') }}"></script>
    <script src="{{ asset('vendors/lodash/lodash.min.js') }}"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
    <script src="{{ asset('vendors/list.js/list.min.js') }}"></script>
    <script src="{{ asset('assets/js/theme.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

@yield('scripts')

</body>

</html>
