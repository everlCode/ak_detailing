@extends('layouts.app')

@section('title', 'Детейлинг в Кирове — химчистка, полировка, керамика')

@section('content')

    {{-- Баннер --}}
    <section class="hero" style="background-image: url('{{ asset($settings['hero_image'] ?? 'images/car.webp') }}'), linear-gradient(160deg, rgba(0,0,0,0.72) 0%, rgba(0,0,0,0.45) 100%); background-blend-mode: overlay;">
        <div class="container hero-content">
            <span class="hero-badge">Детейлинг в Кирове</span>
            <h1 class="hero-title">
                Качественный детейлинг<br>для вашего автомобиля
            </h1>
            <div class="hero-accent-line"></div>
            <p class="hero-subtitle">Химчистка, полировка, керамика — выполним быстро и качественно.<br>Запишитесь прямо сейчас!</p>
            <button type="button" class="hero-cta" data-bs-toggle="modal" data-bs-target="#bookingModal" data-bs-service="">Записаться онлайн</button>
        </div>
    </section>

    {{-- Подключаем partial со слайдером услуг --}}
    @include('partials.services-grid')

    {{-- Примеры работ --}}
    @if($portfolio->isNotEmpty())
    <section class="portfolio-section">
        <div class="container">
            <div class="section-heading">
                <h2>Примеры работ</h2>
                <span class="section-heading__line"></span>
            </div>
            <div class="portfolio-grid">
                @foreach($portfolio as $item)
                    <div class="portfolio-item">
                        <img src="{{ img($item->path, 480, 360) }}" alt="{{ $item->alt ?? 'Пример работы' }}" loading="lazy">
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

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
