@extends('layouts.app')

@section('title', $service->name . ' в Кирове — A.K Detailing')

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
            <h1 class="svc-hero__title">{{ $service->name }}</h1>
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
                    <h2>Об услуге</h2>
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
