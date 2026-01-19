@push('head')
<!-- Swiper CSS (CDN) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
@endpush

<div class="services-section">
    <div class="container">
        <h2>Наши услуги</h2>

        <div class="services-slider swiper" aria-label="Слайдер наших услуг">
            <div class="slides swiper-wrapper">
                <div class="service-slide swiper-slide" role="group" aria-roledescription="slide" aria-label="Полировка кузова">
                    <div class="slide-image">
                        <img src="{{ asset('/images/car.jpg') }}" alt="Полировка кузова">
                    </div>
                    <div class="slide-content">
                        <h3>Полировка кузова</h3>
                        <p>Комплексная полировка вернёт блеск и удалит микроскребки. Используем профессиональную абразивную и финишную полировку.</p>
                        <button>Записаться</button>
                    </div>
                </div>

                <div class="service-slide swiper-slide" role="group" aria-roledescription="slide" aria-label="Химчистка салона">
                    <div class="slide-image">
                        <img src="{{ asset('/images/car.jpg') }}" alt="Химчистка салона">
                    </div>
                    <div class="slide-content">
                        <h3>Химчистка салона</h3>
                        <p>Глубокая чистка ткани и кожи, удаление запахов и пятен с применением безопасных профессиональных средств.</p>
                        <button>Записаться</button>
                    </div>
                </div>

                <div class="service-slide swiper-slide" role="group" aria-roledescription="slide" aria-label="Нанесение керамики">
                    <div class="slide-image">
                        <img src="{{ asset('/images/car.jpg') }}" alt="Нанесение керамики">
                    </div>
                    <div class="slide-content">
                        <h3>Нанесение керамики</h3>
                        <p>Долговременная защита кузова, повышенная гидрофобность и устойчивость к агрессивным внешним воздействиям.</p>
                        <button>Записаться</button>
                    </div>
                </div>
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
</div>

@push('scripts')
<!-- Swiper JS (CDN) + инициализация нашего скрипта -->
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script src="{{ asset('/js/services-slider.js') }}" defer></script>
@endpush

<!-- Невидимый якорь для кнопки "Записаться" -->
<div id="booking" style="position:relative; height:1px; width:1px; overflow:hidden; visibility:hidden;"></div>

