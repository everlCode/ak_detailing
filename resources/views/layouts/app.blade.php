<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Детейлинг услуги')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/meta/favicon.ico') }}">
    <link rel="shortcut icon" href="{{ asset('images/meta/favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/meta/apple-touch-icon.png.png') }}">

    {{-- Подключаем шрифты до основных стилей чтобы избежать мерцания и обеспечить доступность семейства в CSS --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Russo+One&display=swap" rel="stylesheet">
    <!-- Добавляем Inter для интерфейса формы -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS (CDN) - подключаем ДО app.css, чтобы переопределения работали -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        (function(m,e,t,r,i,k,a){
            console.log('Yandex.Metrika init');
            m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
            m[i].l=1*new Date();
            for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
            k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)
        })(window, document,'script','https://mc.yandex.ru/metrika/tag.js?id=106614691', 'ym');

        ym(106614691, 'init', {webvisor:true, clickmap:true, ecommerce:"dataLayer", referrer: document.referrer, url: location.href, accurateTrackBounce:true, trackLinks:true});
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/106614691" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->
    {{-- Vite assets (app.css / app.js) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    <style>
        .banner-slider { background: linear-gradient(120deg, #007bff 50%, #2d3a4b 100%); color: #fff; text-align: center; padding: 60px 0 40px 0;}
        .service-menu { margin: 40px 0 30px 0;}
        .contact-block { background: #f7f7f7; padding: 20px 0; border-bottom: 1px solid #e0e0e0;}
        .footer { background: #2d3a4b; color: #fff; padding: 20px 0; text-align: center; margin-top: 40px;}
    </style>
    @stack('head')
</head>
<body>
{{-- Хедер --}}
@include('partials.header')

{{-- Flash-сообщение --}}
@if(session('success'))
    <div class="container mt-4">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif

{{-- Основной контент --}}
<main>
    @yield('content')
</main>

{{-- Футер --}}
@include('partials.footer')

{{-- Вставка модалки записи --}}
@include('partials.booking-modal')

{{-- Bootstrap (CDN) оставляю для компонентов, если нужны --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

{{-- Vite подключает resources/js/app.js, который импортирует burger.js --}}

@stack('scripts')
</body>
</html>
