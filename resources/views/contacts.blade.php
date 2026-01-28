@extends('layouts.app')

@section('title', 'Контакты')

@section('content')
<div class="container" style="padding: 100px 16px 48px;">
    <div class="contact-card" style="background:#fff;border-radius:14px;box-shadow:0 8px 24px rgba(15,23,42,0.08);padding:28px;">
        <div class="d-flex flex-column flex-md-row gap-4">
            <div class="flex-fill" style="min-width:280px;">
                <h1 style="font-family: 'Russo One', Inter, sans-serif; font-size:28px; margin-bottom:8px;">Контакты</h1>
                <p style="color:#556; font-size:15px; margin-bottom:18px;">Оставьте свои контакты — мы свяжемся с вами сразу после получения заявки.</p>

                <div class="mb-3" style="display:flex;gap:12px;align-items:flex-start;">
                    <div style="font-size:20px;">📞</div>
                    <div>
                        <div style="font-weight:600">Телефон</div>
                        <a href="tel:+77001234567" style="color:#0b5fff;">+7 700 123-45-67</a>
                    </div>
                </div>

                <div class="mb-3" style="display:flex;gap:12px;align-items:flex-start;">
                    <div style="font-size:20px;">📍</div>
                    <div>
                        <div style="font-weight:600">Адрес</div>
                        <div>г. Алматы, ул. Примерная, 10</div>
                    </div>
                </div>

                <div class="mb-3" style="display:flex;gap:12px;align-items:flex-start;">
                    <div style="font-size:20px;">💬</div>
                    <div>
                        <div style="font-weight:600">Группа ВКонтакте</div>
                        <div><a href="https://vk.com/example" target="_blank" rel="noopener" style="color:#0b5fff;">vk.com/example</a></div>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('home') }}" class="btn btn-outline" style="margin-right:8px;">На главную</a>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bookingModal">Записаться</button>
                </div>
            </div>

            <div class="flex-fill" style="min-height:300px;">
                <div id="yandex-map" style="width:100%; height:100%; min-height:300px; border-radius:10px; overflow:hidden;"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" defer></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        function initMap() {
            if (typeof ymaps === 'undefined') return;

            try {
                ymaps.ready(function () {
                    var map = new ymaps.Map('yandex-map', {
                        center: [43.238949, 76.889709],
                        zoom: 12,
                        controls: ['zoomControl']
                    });

                    var placemark = new ymaps.Placemark([43.238949, 76.889709], {
                        hintContent: 'Наш офис',
                        balloonContent: 'Здесь вы можете нас найти'
                    });

                    map.geoObjects.removeAll();
                    map.geoObjects.add(placemark);
                });
            } catch (e) {
                // fail silently
                console.error('ymaps init error', e);
            }
        }

        if (window.ymaps) {
            initMap();
        } else {
            var t = setInterval(function () {
                if (window.ymaps) {
                    clearInterval(t);
                    initMap();
                }
            }, 200);
        }
    });
</script>
@endpush
