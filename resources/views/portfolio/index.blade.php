@extends('layouts.app')

@section('title', 'Наши работы — детейлинг автомобилей в Кирове | A.K Detailing')

@push('head')
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
        }
    ]
}
</script>
@endpush

@php
    view()->share('metaDescription', 'Реальные примеры детейлинга автомобилей в Кирове: полировка, химчистка, керамика. Фото до и после. A.K Detailing.');
@endphp

@section('content')

<section class="svc-hero" style="min-height: 30vh;">
    <div class="svc-hero__overlay"></div>
    <div class="container svc-hero__content">
        <nav class="svc-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ url('/') }}">Главная</a>
            <span>/</span>
            <span>Наши работы</span>
        </nav>
        <h1 class="svc-hero__title">Наши работы</h1>
        <p class="svc-hero__sub">Реальные кейсы — марка, модель, услуга и фотографии</p>
    </div>
</section>

<section class="portfolio-cases-section">
    <div class="container">
        @if($cases->isEmpty())
            <p class="portfolio-cases-empty">Кейсы скоро появятся.</p>
        @else
        <div class="portfolio-cases-grid">
            @foreach($cases as $case)
            @php $thumb = $case->mainImage; @endphp
            <a href="{{ route('portfolio.show', $case->slug) }}" class="portfolio-case-card">
                <div class="portfolio-case-card__img-wrap">
                    @if($thumb)
                        <img
                            src="{{ img($thumb->path, 480, 320) }}"
                            alt="{{ $thumb->alt ?: $case->title }}"
                            loading="lazy"
                            class="portfolio-case-card__img"
                        >
                    @else
                        <div class="portfolio-case-card__no-img"></div>
                    @endif
                </div>
                <div class="portfolio-case-card__body">
                    <span class="portfolio-case-card__car">{{ $case->car_make }} {{ $case->car_model }}</span>
                    <h2 class="portfolio-case-card__title">{{ $case->title }}</h2>
                    @if($case->service)
                        <span class="portfolio-case-card__service">{{ $case->service->name }}</span>
                    @endif
                </div>
            </a>
            @endforeach
        </div>
        @endif
    </div>
</section>

@include('partials.contact-block')

@endsection
