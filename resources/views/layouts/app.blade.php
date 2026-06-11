<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    @php
        $pageDescription = $metaDescription ?? 'Профессиональный детейлинг автомобилей в Кирове. Полировка, нанокерамика, химчистка салона, бронирование плёнкой — A.K Detailing.';
        $ogImage         = $ogImage ?? (!empty($settings['hero_image']) ? asset($settings['hero_image']) : asset('images/og-default.jpg'));
        $canonicalUrl    = url()->current();
    @endphp

    <title>@yield('title', 'Детейлинг услуги в Кирове')</title>
    <meta name="description" content="{{ $pageDescription }}">

    @if(!empty($noindex))
    <meta name="robots" content="noindex, nofollow">
    @endif

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Open Graph --}}
    <meta property="og:type"         content="website">
    <meta property="og:site_name"    content="A.K Detailing">
    <meta property="og:locale"       content="ru_RU">
    <meta property="og:title"        content="@yield('title', 'Детейлинг услуги в Кирове')">
    <meta property="og:description"  content="{{ $pageDescription }}">
    <meta property="og:url"          content="{{ $canonicalUrl }}">
    <meta property="og:image"        content="{{ $ogImage }}">
    <meta property="og:image:width"  content="1200">
    <meta property="og:image:height" content="630">

    {{-- Microdata --}}
    <meta itemprop="name" content="A.K Detailing">
    @if (!empty($settings['phone']))
        <meta itemprop="telephone" content="{{ $settings['phone'] }}">
    @endif
    @if (!empty($settings['address']))
        <meta itemprop="address" content="{{ $settings['address'] }}">
    @endif

    <link rel="canonical" href="{{ $canonicalUrl }}">

    <!-- Favicon -->
    @php $faviconUrl = asset($settings['favicon'] ?? 'images/meta/favicon.ico'); @endphp
    <link rel="icon" href="{{ $faviconUrl }}">
    <link rel="shortcut icon" href="{{ $faviconUrl }}">
    <link rel="apple-touch-icon" href="{{ asset('images/meta/apple-touch-icon.png') }}">

    {{-- JSON-LD LocalBusiness --}}
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "AutoBodyShop",
        "@id": "{{ config('app.url') }}#organization",
        "name": "A.K Detailing",
        "description": "Профессиональный детейлинг автомобилей в Кирове. Полировка, нанокерамика, химчистка салона, бронирование плёнкой.",
        "url": "{{ config('app.url') }}",
        "logo": "{{ !empty($settings['logo']) ? asset($settings['logo']) : asset('images/logo.webp') }}",
        "image": "{{ $ogImage }}",
        "priceRange": "₽₽",
        "telephone": "{{ $settings['phone'] ?? '' }}",
        "address": {
            "@type": "PostalAddress",
            "addressLocality": "Киров",
            "addressRegion": "Кировская область",
            "addressCountry": "RU",
            "streetAddress": "{{ $settings['address'] ?? '' }}"
        },
        "geo": {
            "@type": "GeoCoordinates",
            "latitude": "58.6035",
            "longitude": "49.6679"
        }@if(!empty($settings['vk_link'])),
        "sameAs": ["{{ $settings['vk_link'] }}"]@endif

    }
    </script>

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
