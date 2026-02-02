@push('head')
<!-- Swiper CSS (CDN) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
@endpush

<section class="services-section">
    <div class="container">
        <h2>Наши услуги</h2>

        <div class="services-slider swiper" aria-label="Слайдер наших услуг">
            <div class="slides swiper-wrapper">
                @if(isset($services) && $services->count())
                    @foreach($services as $service)
                        <div class="service-slide swiper-slide" role="group" aria-roledescription="slide" aria-label="{{ $service->name }}">
                            <div class="slide-image">
                                <img src="{{ asset('/images/car.jpg') }}" alt="{{ $service->name }}">
                            </div>
                            <div class="slide-content">
                                <h3>{{ $service->name }}</h3>
                                <p>{{ Str::limit($service->short_description, 160) }}</p>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bookingModal" data-bs-service="{{ $service->id }}">Записаться</button>
                            </div>
                        </div>
                    @endforeach
                @else
                    <!-- fallback static slides -->
                    <div class="service-slide swiper-slide" role="group" aria-roledescription="slide" aria-label="Полировка кузова">
                        <div class="slide-image">
                            <img src="{{ asset('/images/car.jpg') }}" alt="Полировка кузова">
                        </div>
                        <div class="slide-content">
                            <h3>Полировка кузова</h3>
                            <p>Комплексная полировка вернёт блеск и удалит микроскребки. Используем профессиональную абразивную и финишную полировку.</p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bookingModal" data-bs-service="1">Записаться</button>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Кнопки навигации со SVG-иконками -->
            <button class="slider-btn prev swiper-button-prev" aria-label="Предыдущий слайд">
                <svg width="18" height="30" viewBox="0 0 18 30" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M16 28L2 15L16 2" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            <button class="slider-btn next swiper-button-next" aria-label="Следующий слайд">
                <svg width="18" height="30" viewBox="0 0 18 30" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M2 28L16 15L2 2" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>

            <!-- Пагинация -->
            <div class="slider-dots swiper-pagination" aria-hidden="false"></div>
        </div>
    </div>
</section>

@push('scripts')
<!-- Swiper JS (CDN) + инициализация нашего скрипта -->
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
@endpush

<!-- Невидимый якорь для кнопки "Записаться" -->
<div id="booking" style="position:relative; height:1px; width:1px; overflow:hidden; visibility:hidden;"></div>
