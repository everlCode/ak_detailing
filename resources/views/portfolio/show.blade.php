@extends('layouts.app')

@php
    $metaTitle = $case->title . ' — ' . $case->car_make . ' ' . $case->car_model;
    if ($case->car_year) $metaTitle .= ' ' . $case->car_year;
    $metaTitle .= ' | A.K Detailing';

    $firstImage = $case->images->first();
@endphp
@section('title', $metaTitle)

@push('head')
@if($firstImage)
<meta property="og:image" content="{{ asset($firstImage->path) }}">
<meta property="og:image:width"  content="1200">
<meta property="og:image:height" content="630">
@endif
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Article",
    "headline": "{{ $case->title }}",
    "description": "{{ $case->meta_description ?: $case->car_make . ' ' . $case->car_model . ' — ' . ($case->service?->name ?? 'детейлинг') }}",
    "url": "{{ url()->current() }}"@if($firstImage),
    "image": "{{ asset($firstImage->path) }}"@endif,
    "author": {
        "@type": "Organization",
        "name": "A.K Detailing"
    }
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
            "name": "Наши работы",
            "item": "{{ url('/portfolio') }}"
        },
        {
            "@type": "ListItem",
            "position": 3,
            "name": "{{ $case->title }}",
            "item": "{{ url()->current() }}"
        }
    ]
}
</script>
@endpush

@section('content')

<section class="svc-hero"
    @if($firstImage) style="background-image: url('{{ asset($firstImage->path) }}')" @endif>
    <div class="svc-hero__overlay"></div>
    <div class="container svc-hero__content">
        <nav class="svc-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ url('/') }}">Главная</a>
            <span>/</span>
            <a href="{{ route('portfolio.index') }}">Наши работы</a>
            <span>/</span>
            <span>{{ $case->title }}</span>
        </nav>
        <h1 class="svc-hero__title">{{ $case->title }}</h1>
        <p class="svc-hero__sub">
            {{ $case->car_make }} {{ $case->car_model }}@if($case->car_year), {{ $case->car_year }} г.@endif
            @if($case->service) — {{ $case->service->name }}@endif
        </p>
        <div class="svc-hero__actions">
            <button type="button" class="hero-cta"
                    data-bs-toggle="modal" data-bs-target="#bookingModal"
                    @if($case->service_id) data-bs-service="{{ $case->service_id }}" @endif>
                Записаться
            </button>
        </div>
    </div>
</section>

<section class="svc-body">
    <div class="container">
        <div class="portfolio-case-meta">
            <div class="portfolio-case-meta__item">
                <span class="portfolio-case-meta__label">Марка и модель</span>
                <span class="portfolio-case-meta__value">{{ $case->car_make }} {{ $case->car_model }}@if($case->car_year) {{ $case->car_year }}@endif</span>
            </div>
            @if($case->service)
            <div class="portfolio-case-meta__item">
                <span class="portfolio-case-meta__label">Услуга</span>
                <a href="{{ route('services.show', $case->service->alias) }}" class="portfolio-case-meta__value portfolio-case-meta__value--link">
                    {{ $case->service->name }}
                </a>
            </div>
            @endif
            <div class="portfolio-case-meta__item">
                <span class="portfolio-case-meta__label">Просмотры</span>
                <span class="portfolio-case-meta__value">{{ number_format($case->views, 0, '.', ' ') }}</span>
            </div>
        </div>

        @if($case->description)
        <div class="svc-description-content portfolio-case-description">
            {!! $case->description !!}
        </div>
        @endif
    </div>
</section>

@if($case->images->isNotEmpty())
<section class="svc-examples">
    <div class="container">
        <div class="section-heading">
            <h2>Фотографии</h2>
            <span class="section-heading__line"></span>
        </div>
        <div class="svc-examples-grid">
            @foreach($case->images as $img)
            <div class="svc-example-item">
                <img
                    src="{{ img($img->path, 480, 360) }}"
                    alt="{{ $img->alt ?: $case->title }}"
                    loading="lazy"
                >
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="svc-cta-banner">
    <div class="container svc-cta-banner__inner">
        <div>
            <h2 class="svc-cta-banner__title">Хотите такой же результат?</h2>
            <p class="svc-cta-banner__sub">Оставьте заявку — мы свяжемся и подберём удобное время</p>
        </div>
        <button type="button" class="hero-cta"
                data-bs-toggle="modal" data-bs-target="#bookingModal"
                @if($case->service_id) data-bs-service="{{ $case->service_id }}" @endif>
            Записаться онлайн
        </button>
    </div>
</section>

@include('partials.contact-block')

@endsection
