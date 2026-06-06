@extends('layouts.app')

@section('title', 'Детейлинг в Кирове — химчистка, полировка, керамика')

@section('content')

    {{-- Баннер / Слайдер --}}
    <section class="hero" style="background-image: url('{{ asset($settings['hero_image'] ?? 'images/car.webp') }}'), linear-gradient(180deg, rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.65)); background-blend-mode: overlay;">
        <div class="container hero-content">
            <h1 class="hero-title">
                Качественный детейлинг в Кирове
            </h1>
            <p class="hero-subtitle">Выполним услугу быстро и качественно. Запишитесь прямо сейчас, мы свяжемся с вами и проконсультируем!</p>
            <button type="button" class="hero-cta btn btn-primary" data-bs-toggle="modal" data-bs-target="#bookingModal" data-bs-service="">Записаться</button>
        </div>
    </section>

    {{-- Подключаем partial со слайдером услуг --}}
    @include('partials.services-grid')

    {{-- Подключаем partial с блоком контактов --}}
    @include('partials.contact-block', [

    'settings' => $settings
])

@endsection

@section('services-dropdown')
    <ul class="dropdown-menu">
        @foreach ($services as $service)
            <li><a href="{{ route('services.show', ['alias' => $service->alias]) }}">{{ $service->name }}</a></li>
        @endforeach
    </ul>
@endsection

@push('scripts')

@endpush
