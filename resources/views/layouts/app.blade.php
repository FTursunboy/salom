<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>anons.tj — афиша событий и мероприятий в Душанбе</title>
        <meta name="description" content="Афиша Душанбе: расписание событий, концертов, кино, фестивалей и других мероприятий. Узнайте, куда сходить в Душанбе на anons.tj и выберите лучшее развлечение по вашему вкусу.">
        <meta name="title" content="Афиша Душанбе — куда сходить: концерты, кино, фестивали, мероприятия — anons.tj">

        <!-- Мета-ключевые слова -->
        <meta name="keywords" content="афиша Душанбе, куда сходить в Душанбе, расписание концертов, киноафиша Душанбе, мероприятия Душанбе, события в Душанбе, афиша событий Душанбе">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div  class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
