<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Детейлинг услуги')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Подключаем шрифты до основных стилей чтобы избежать мерцания и обеспечить доступность семейства в CSS --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Russo+One&display=swap" rel="stylesheet">
    <!-- Добавляем Inter для интерфейса формы -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    {{-- Подключение стилей и скриптов без Vite (прямые ассеты) --}}
    <link rel="stylesheet" href="{{ asset('/css/normalize.css') }}">
    <!-- Bootstrap CSS (CDN) - подключаем ДО app.css, чтобы переопределения работали -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
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

{{-- Подключаем единый статический JS-файл для бургер-меню --}}
<script src="{{ asset('/js/burger.js') }}" defer></script>

@stack('scripts')
</body>
</html>
