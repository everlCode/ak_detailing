@push('head')
<!-- Yandex Maps API -->
<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" defer></script>
@endpush

<section class="map-block">
    <div class="container">
        <h2>Где мы находимся</h2>
        <p class="map-sub">Заезд и парковка у входа. Приезжайте — покажем образцы работ.</p>

        <div class="map-container">
            {{-- Передаём координаты из настроек: ключ `map_coords` в формате "lat,lon" --}}
            <div id="yandex-map" aria-label="Карта с расположением студии" data-coords="{{ $settings['map_coords'] ?? '58.578176,49.670084' }}"></div>
        </div>
    </div>
</section>

@push('scripts')
<script src="{{ asset('/js/map-widget.js') }}" defer></script>
@endpush
