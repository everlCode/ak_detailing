<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Детейлинг услуги')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- Подключение стилей и скриптов без Vite (прямые ассеты) --}}
    <link rel="stylesheet" href="{{ asset('/css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Russo+One&display=swap" rel="stylesheet">
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

{{-- Основной контент --}}
<main>
    @yield('content')
</main>

{{-- Футер --}}
@include('partials.footer')

{{-- Bootstrap (CDN) оставляю для компонентов, если нужны --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

{{-- Подключаем единый статический JS-файл для бургер-меню --}}
<script src="{{ asset('/js/burger.js') }}" defer></script>

@stack('scripts')
</body>
</html>
