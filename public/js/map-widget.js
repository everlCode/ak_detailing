// Инициализация виджета Yandex Maps для блока контактов
(function(){
    function initMap(){
        if(!window.ymaps) return;
        var mapEl = document.getElementById('yandex-map');
        if(!mapEl) return;

        // Берём координаты из data-атрибута data-coords у элемента #yandex-map (формат "lat,lon").
        var center = [58.578176, 49.670084];
        try {
            var coordsAttr = mapEl.getAttribute('data-coords');
            if (coordsAttr && typeof coordsAttr === 'string' && coordsAttr.indexOf(',') !== -1) {
                var parts = coordsAttr.split(',').map(function(s){ return parseFloat(s.trim()); });
                if (parts.length === 2 && !isNaN(parts[0]) && !isNaN(parts[1])) {
                    center = parts;
                }
            }
        } catch(e) {
            // используем запасные координаты
        }

        try {
            var map = new ymaps.Map('yandex-map', {
                center: center,
                zoom: 13,
                controls: ['zoomControl','fullscreenControl']
            }, {
                suppressMapOpenBlock: true
            });

            var placemark = new ymaps.Placemark(center, {
                balloonContent: 'A.K detailing (примерное местоположение)'
            }, {
                preset: 'islands#icon',
                iconColor: '#4f46e5'
            });

            map.geoObjects.add(placemark);

            // Небольшая адаптация: корректируем центр при изменении размеров, чтобы метка оставалась видимой
            window.addEventListener('resize', function(){
                setTimeout(function(){ map.container.fitToViewport(); map.setCenter(center); }, 200);
            });
        } catch(e){
            // fail silently
            // console.error(e);
        }
    }

    if(window.ymaps) ymaps.ready(initMap);
    else {
        // Если API загружается с defer, ymaps.ready вызовится сам; на всякий случай повторяем с задержкой
        var check = setInterval(function(){ if(window.ymaps){ clearInterval(check); ymaps.ready(initMap); } }, 200);
        setTimeout(function(){ clearInterval(check); }, 5000);
    }
})();
