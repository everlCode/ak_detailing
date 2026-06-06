<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Детейлинг услуги в Кирове')</title>
    <meta name="description" content="{{ $metaDescription ?? 'Описание по умолчанию' }}">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta itemprop="name" content="A.K Detailing">
    @if (!empty($settings['phone']))
        <meta itemprop="telephone" content="{{ $settings['phone'] }}">
    @endif
    @if (!empty($settings['address']))
        <meta itemprop="address" content="{{ $settings['address'] }}">
    @endif

    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/meta/favicon.ico') }}">
    <link rel="shortcut icon" href="{{ asset('images/meta/favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/meta/apple-touch-icon.png') }}">

    {{-- CSS --}}
    @vite(['resources/css/bootstrap.min.css'])
    @stack('styles')

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

{{-- Модалка записи (lazy load по клику) --}}
@include('partials.booking-modal')

{{-- JS оптимизированный --}}

{{-- Vite App JS --}}

@vite(['resources/css/app.css'])
<script type="module" defer src="{{ Vite::asset('resources/js/app.js') }}"></script>
<script type="module" defer src="{{ Vite::asset('resources/js/bootstrap.bundle.min.js') }}"></script>


{{-- Yandex Metrika (async) --}}
<script async src="https://mc.yandex.ru/metrika/tag.js?id=106614691"></script>
<script>
    // Инициализация Metrika без блокировки рендера
    window.ym = window.ym || function(){ (ym.a = ym.a || []).push(arguments) };
    ym.l = 1*new Date();
    ym(106614691, 'init', {
        webvisor:true,
        clickmap:true,
        ecommerce:"dataLayer",
        referrer: document.referrer,
        url: location.href,
        accurateTrackBounce:true,
        trackLinks:true
    });
</script>

@stack('scripts')
</body>
</html>
