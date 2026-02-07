<section class="map-block">
    <div class="container">
        <h2>Где мы находимся</h2>
        <p class="map-sub">Заезд и парковка у входа. Приезжайте — покажем образцы работ.</p>

        <div class="map-container">
            {{-- Контейнер для карты, координаты --}}
            <div id="yandex-map" aria-label="Карта с расположением студии" data-coords="{{ $settings['map_coords'] ?? '58.578176,49.670084' }}"></div>
        </div>
    </div>
</section>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const mapEl = document.getElementById('yandex-map');
            if (!mapEl) return;

            const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                loadYandexMaps(initMap);
                obs.unobserve(mapEl);
            }
        });
    }, { threshold: 0.1 });

    observer.observe(mapEl);

            // Функция для загрузки скрипта Яндекс.Карт динамически
            function loadYandexMaps(callback) {
                const script = document.createElement('script');
                script.src = 'https://api-maps.yandex.ru/2.1/?lang=ru_RU';
                script.defer = true;
                script.async = true;
                script.onload = callback;
                document.body.appendChild(script);
            }

            // Инициализация карты
            function initMap() {
                const coords = (mapEl.dataset.coords || '58.578203, 49.670062').split(',');
                const lat = parseFloat(coords[0]);
                const lon = parseFloat(coords[1]);

                ymaps.ready(() => {
                    const map = new ymaps.Map('yandex-map', {
                        center: [lat, lon],
                        zoom: 15,
                        controls: ['zoomControl', 'geolocationControl']
                    });

                    const placemark = new ymaps.Placemark(
                        [lat, lon],
                        {
                            hintContent: 'Наша студия',
                            balloonContent: 'Добро пожаловать!'
                        },
                        {
                            preset: 'islands#redIcon'
                        }
                    );

                    map.geoObjects.add(placemark);
                });

            }

            // Загружаем API только когда DOM готов
            loadYandexMaps(initMap);
        });
    </script>
@endpush
