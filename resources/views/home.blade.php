@extends('layouts.app')

@section('title', 'Главная')

@section('content')

    {{-- Баннер / Слайдер --}}
    <section class="hero">
        <div class="container hero-content">
            <h1 class="hero-title">
                <span class="hero-title--big">A.K</span>
                <span class="hero-title--small">detalng studio</span>
            </h1>
            <p class="hero-subtitle">Качественные услуги по низким ценам</p>
            <button class="hero-cta">Записаться</button>
        </div>
    </section>

    {{-- Подключаем partial со слайдером услуг --}}
    @include('partials.services-slider')

    {{-- Подключаем partial с блоком контактов --}}
    @include('partials.contact-block')

    {{-- Подключаем partial с картой --}}
    @include('partials.map-block')

@endsection

@section('services-dropdown')
    <ul class="dropdown-menu">
        @foreach ($services as $service)
            <li><a href="{{ route('services.show', ['alias' => $service->alias]) }}">{{ $service->name }}</a></li>
        @endforeach
    </ul>
@endsection

@push('scripts')
<!-- Swiper JS (CDN) + инициализация нашего скрипта -->
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script src="{{ asset('/js/services-slider.js') }}" defer></script>
@endpush
