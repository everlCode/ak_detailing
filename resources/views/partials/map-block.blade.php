@push('head')
<!-- Yandex Maps API -->
<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" defer></script>
@endpush

<div class="map-block">
    <div class="container">
        <h2>Где мы находимся</h2>
        <p class="map-sub">Заезд и парковка у входа. Приезжайте — покажем образцы работ.</p>

        <div class="map-container">
            <div id="yandex-map" aria-label="Карта с расположением студии"></div>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('/js/map-widget.js') }}" defer></script>
@endpush
