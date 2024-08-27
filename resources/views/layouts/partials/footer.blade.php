<div class="bg-falcon mt-3">
    <footer class="container footer bg-falcon pt-5">
        <div class="row align-items-center d-flex">
            <div class="col-auto order-1">
                <a class="text-decoration-none" href="{{ route('home') }}">
                    <h2 class="text-primary fw-bold">salom</h2>
                </a>
            </div>
            <div class="col-auto order-3 order-md-2 mt-2 mt-md-0">
                <div class="row">
                    <div class="col-auto">
                        <a href="https://t.me/salomsupportbot" target="_blank" class="text-900">Контакты</a>
                    </div>
                    <div class="col-auto">
                        <a href="https://t.me/salomsupportbot" target="_blank" class="text-900">Реклама</a>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('about') }}" class="text-900">О проекте</a>
                    </div>
                </div>
            </div>
            <div class="col-auto col-end float-right gap-2 ms-auto text-center fs-2 order-2">
                <a href="https://t.me/salomlife" target="_blank"><i class="fab fa-telegram text-500"></i></a>
                <a href="https://www.instagram.com/salom.life/" target="_blank"><i class="fab fa-instagram text-500"></i></a>
                <a href="#"><i class="fab fa-facebook text-500"></i></a>
            </div>

        </div>

        <div class="row g-0 justify-content-between fs--1 mt-4">
            <div class="col-12 col-sm-auto text-center order-2 order-md-1">
                <p class="text-600">
                    <span class="fw-bold">© Салом</span>, {{ \Carbon\Carbon::now()->year }}
                </p>
            </div>
            <div class="col-12 col-sm-auto order-1">
                <p class="text-600">
                    {{--<a href="">Правило конфиденциальности</a>
                    и --}}
                    <a href="{{ route('terms') }}">Пользовательское соглашение</a>
                </p>
            </div>
        </div>
    </footer>

</div>
