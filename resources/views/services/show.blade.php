@extends('layouts.app')

@php
    $metaTitle = $service->name . ' в Кирове';
    if (!empty($service->price) && $service->price > 0) {
        $metaTitle .= ' — от ' . number_format($service->price, 0, '.', ' ') . ' ₽';
    }
    $metaTitle .= ' | A.K Detailing';
@endphp
@section('title', $metaTitle)

@push('head')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Service",
    "name": "{{ $service->name }}",
    "description": "{{ $service->meta_description ?: $service->short_description ?: $service->name . ' в Кирове — A.K Detailing' }}",
    "url": "{{ url()->current() }}"@if($service->mainImage?->path),
    "image": "{{ asset($service->mainImage->path) }}"@endif,
    "areaServed": {
        "@type": "City",
        "name": "Киров"
    },
    "provider": {
        "@type": "AutoBodyShop",
        "@id": "{{ config('app.url') }}#organization",
        "name": "A.K Detailing"
    }@if(!empty($service->price) && $service->price > 0),
    "offers": {
        "@type": "Offer",
        "priceCurrency": "RUB",
        "price": "{{ (int)$service->price }}",
        "availability": "https://schema.org/InStock"
    }@endif
}
</script>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
        {
            "@type": "ListItem",
            "position": 1,
            "name": "Главная",
            "item": "{{ url('/') }}"
        },
        {
            "@type": "ListItem",
            "position": 2,
            "name": "{{ $service->name }}",
            "item": "{{ url()->current() }}"
        }
    ]
}
</script>
@endpush

@section('content')

    {{-- Hero --}}
    @php
        $heroPath = $service->mainImage?->path;
        $heroAlt  = $service->mainImage?->alt ?: $service->name;
    @endphp
    <section class="svc-hero" @if($heroPath) style="background-image: url('{{ asset($heroPath) }}')" @endif>
        <div class="svc-hero__overlay"></div>
        <div class="container svc-hero__content">
            <nav class="svc-breadcrumb" aria-label="Breadcrumb">
                <a href="{{ url('/') }}">Главная</a>
                <span>/</span>
                <span>{{ $service->name }}</span>
            </nav>
            <h1 class="svc-hero__title">{{ $service->name }} в Кирове</h1>
            @if(!empty($service->short_description))
                <p class="svc-hero__sub">{{ $service->short_description }}</p>
            @endif
            <div class="svc-hero__actions">
                @if(!empty($service->price) && $service->price > 0)
                    <span class="svc-hero__price">от {{ number_format($service->price, 0, '.', ' ') }} ₽</span>
                @endif
                <button type="button" class="hero-cta"
                        data-bs-toggle="modal" data-bs-target="#bookingModal"
                        data-bs-service="{{ $service->id }}">
                    Записаться
                </button>
            </div>
        </div>
    </section>

    {{-- Описание --}}
    <section class="svc-body">
        <div class="container svc-body__grid">
            <div class="svc-body__description">
                <div class="section-heading">
                    <h2>{{ $service->name }}: что входит в услугу</h2>
                    <span class="section-heading__line"></span>
                </div>
                <div class="svc-description-content">
                    {!! $service->description !!}
                </div>
            </div>

            <aside class="svc-body__sidebar">
                <div class="svc-sidebar-card">
                    @if($heroPath)
                        <img src="{{ img($heroPath, 480, 320) }}" alt="{{ $heroAlt }}" class="svc-sidebar-card__img">
                    @endif
                    <div class="svc-sidebar-card__body">
                        @if(!empty($service->price) && $service->price > 0)
                        <div class="svc-sidebar-card__price">
                            <span class="svc-sidebar-card__price-label">Стоимость</span>
                            <span class="svc-sidebar-card__price-value">от {{ number_format($service->price, 0, '.', ' ') }} ₽</span>
                        </div>
                        @endif
                        <button type="button" class="hero-cta svc-sidebar-card__btn"
                                data-bs-toggle="modal" data-bs-target="#bookingModal"
                                data-bs-service="{{ $service->id }}">
                            Записаться онлайн
                        </button>
                        <p class="svc-sidebar-card__hint">Свяжемся с вами и уточним детали</p>
                    </div>
                </div>
            </aside>
        </div>
    </section>

    {{-- Примеры работ --}}
    @if($service->exampleImages->isNotEmpty())
    <section class="svc-examples">
        <div class="container">
            <div class="section-heading">
                <h2>Примеры работ</h2>
                <span class="section-heading__line"></span>
            </div>
            <div class="svc-examples-grid">
                @foreach($service->exampleImages as $img)
                    <div class="svc-example-item">
                        <img src="{{ img($img->path, 480, 360) }}"
                             alt="{{ $img->alt ?: $service->name }}"
                             loading="lazy">
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- Слайдер кейсов портфолио --}}
    @if($cases->isNotEmpty())
    <section class="portfolio-section">
        <div class="container">
            <div class="section-heading">
                <h2>Наши работы — {{ $service->name }}</h2>
                <span class="section-heading__line"></span>
            </div>
        </div>

        <div class="portfolio-swiper-wrap">
            <div class="swiper svc-portfolio-swiper">
                <div class="swiper-wrapper">
                    @foreach($cases as $case)
                    <div class="swiper-slide portfolio-slide">
                        <a href="{{ route('portfolio.show', $case->slug) }}" class="portfolio-slide__inner">
                            @if($case->mainImage)
                            <img
                                src="{{ img($case->mainImage->path, 520, 380) }}"
                                alt="{{ $case->mainImage->alt ?: $case->title }}"
                                loading="lazy"
                                class="portfolio-slide__img"
                            >
                            @else
                            <div class="portfolio-slide__img" style="background:#1e293b;"></div>
                            @endif
                            <div class="portfolio-slide__caption">
                                <span class="portfolio-slide__caption-car">{{ $case->car_make }} {{ $case->car_model }}</span>
                                <span class="portfolio-slide__caption-service">{{ $case->title }}</span>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>

                <button class="portfolio-nav portfolio-nav--prev" aria-label="Назад">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M15 18l-6-6 6-6"/>
                    </svg>
                </button>
                <button class="portfolio-nav portfolio-nav--next" aria-label="Вперёд">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M9 18l6-6-6-6"/>
                    </svg>
                </button>

                <div class="svc-portfolio-pagination swiper-pagination"></div>
            </div>
        </div>

        <div class="container" style="text-align:center;padding-top:24px;">
            <a href="{{ route('portfolio.index') }}" class="portfolio-all-link">Все работы →</a>
        </div>
    </section>
    @endif

    {{-- CTA-баннер --}}
    <section class="svc-cta-banner">
        <div class="container svc-cta-banner__inner">
            <div>
                <h2 class="svc-cta-banner__title">Готовы записаться?</h2>
                <p class="svc-cta-banner__sub">Оставьте заявку — мы свяжемся и подберём удобное время</p>
            </div>
            <button type="button" class="hero-cta"
                    data-bs-toggle="modal" data-bs-target="#bookingModal"
                    data-bs-service="{{ $service->id }}">
                Записаться онлайн
            </button>
        </div>
    </section>

    @include('partials.contact-block')

@endsection

@if($cases->isNotEmpty())
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        new Swiper('.svc-portfolio-swiper', {
            slidesPerView: 1,
            spaceBetween: 12,
            loop: {{ $cases->count() > 1 ? 'true' : 'false' }},
            grabCursor: true,
            autoplay: { delay: 4000, disableOnInteraction: false, pauseOnMouseEnter: true },
            navigation: {
                nextEl: '.portfolio-nav--next',
                prevEl: '.portfolio-nav--prev',
            },
            pagination: {
                el: '.svc-portfolio-pagination',
                clickable: true,
            },
            breakpoints: {
                480:  { slidesPerView: 2, spaceBetween: 12 },
                768:  { slidesPerView: 3, spaceBetween: 16 },
                1024: { slidesPerView: 4, spaceBetween: 16 },
            },
        });
    });
</script>
@endpush
@endif
