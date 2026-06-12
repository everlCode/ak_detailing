@extends('layouts.app')

@section('title', 'Детейлинг в Кирове — химчистка, полировка, керамика')

@push('head')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
@endpush

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

    {{-- Услуги --}}
    @include('partials.services-grid')

    {{-- Примеры работ --}}
    @if($portfolio->isNotEmpty())
    <section class="portfolio-section">
        <div class="container">
            <div class="section-heading">
                <h2>Примеры работ</h2>
                <span class="section-heading__line"></span>
            </div>
        </div>

        <div class="portfolio-swiper-wrap">
            <div class="swiper portfolio-swiper">
                <div class="swiper-wrapper">
                    @foreach($portfolio as $case)
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
                                @if($case->service)
                                <span class="portfolio-slide__caption-service">{{ $case->service->name }}</span>
                                @endif
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

                <div class="portfolio-pagination swiper-pagination"></div>
            </div>
        </div>
        <div class="container" style="text-align:center;padding-top:24px;">
            <a href="{{ route('portfolio.index') }}" class="portfolio-all-link">Все работы →</a>
        </div>
    </section>
    @endif

    {{-- FAQ --}}
    @if($faqs->isNotEmpty())
    <section class="faq-section">
        <div class="container">
            <div class="section-heading">
                <h2>Частые вопросы</h2>
                <span class="section-heading__line"></span>
            </div>
            <div class="faq-list" itemscope itemtype="https://schema.org/FAQPage">
                @foreach($faqs as $faq)
                <div class="faq-item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                    <button class="faq-question" aria-expanded="false" type="button">
                        <span itemprop="name">{{ $faq->question }}</span>
                        <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                            <path d="M6 9l6 6 6-6"/>
                        </svg>
                    </button>
                    <div class="faq-answer" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                        <p itemprop="text">{{ $faq->answer }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- Контакты --}}
    @include('partials.contact-block', ['settings' => $settings])

@endsection

@section('services-dropdown')
    <ul class="dropdown-menu">
        @foreach ($services as $service)
            <li><a href="{{ route('services.show', ['alias' => $service->alias]) }}">{{ $service->name }}</a></li>
        @endforeach
    </ul>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    document.querySelectorAll('.faq-question').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var item = btn.closest('.faq-item');
            var expanded = btn.getAttribute('aria-expanded') === 'true';
            document.querySelectorAll('.faq-item.is-open').forEach(function(el) {
                el.classList.remove('is-open');
                el.querySelector('.faq-question').setAttribute('aria-expanded', 'false');
            });
            if (!expanded) {
                item.classList.add('is-open');
                btn.setAttribute('aria-expanded', 'true');
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        new Swiper('.portfolio-swiper', {
            slidesPerView: 1,
            spaceBetween: 12,
            loop: true,
            grabCursor: true,
            autoplay: { delay: 4000, disableOnInteraction: false, pauseOnMouseEnter: true },
            navigation: {
                nextEl: '.portfolio-nav--next',
                prevEl: '.portfolio-nav--prev',
            },
            pagination: {
                el: '.portfolio-pagination',
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
