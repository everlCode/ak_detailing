// services-slider.js — инициализация слайдера услуг (Swip-er if available, fallback otherwise)
(function(){
    const root = document.querySelector('.services-slider');
    if(!root) return;

    // Если Swiper доступен, используем его
    if(window.Swiper) {
        // eslint-disable-next-line no-unused-vars
        const swiper = new Swiper(root, {
            loop: true,
            slidesPerView: 1,
            spaceBetween: 24,
            grabCursor: true,
            keyboard: { enabled: true, onlyInViewport: true },
            autoplay: { delay: 4500, disableOnInteraction: false },
            navigation: { nextEl: root.querySelector('.swiper-button-next'), prevEl: root.querySelector('.swiper-button-prev') },
            pagination: { el: root.querySelector('.swiper-pagination'), clickable: true, bulletClass: 'swiper-pagination-bullet', bulletActiveClass: 'swiper-pagination-bullet-active' },
            a11y: true,
        });

        // При фокусе/ховере останавливаем автоплей
        root.addEventListener('mouseenter', () => { if(swiper && swiper.autoplay) swiper.autoplay.stop(); });
        root.addEventListener('mouseleave', () => { if(swiper && swiper.autoplay) swiper.autoplay.start(); });
        root.addEventListener('focusin', () => { if(swiper && swiper.autoplay) swiper.autoplay.stop(); });
        root.addEventListener('focusout', () => { if(swiper && swiper.autoplay) swiper.autoplay.start(); });

        return;
    }

    // Fallback — если Swiper не загрузился
    const slidesWrap = root.querySelector('.slides');
    const slides = Array.from(root.querySelectorAll('.service-slide'));
    const prevBtn = root.querySelector('.slider-btn.prev');
    const nextBtn = root.querySelector('.slider-btn.next');
    const dotsWrap = root.querySelector('.slider-dots');
    let index = 0;
    let autoplayId = null;
    const AUTOPLAY_INTERVAL = 4500;

    // Создаём точки
    slides.forEach((_, i) => {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.ariaLabel = `Перейти к слайду ${i+1}`;
        btn.dataset.index = i;
        if(i === 0) btn.classList.add('active');
        btn.addEventListener('click', () => goTo(i));
        dotsWrap.appendChild(btn);
    });

    const dots = Array.from(dotsWrap.children);

    function update() {
        slidesWrap.style.transform = `translateX(-${index * 100}%)`;
        dots.forEach((d, i) => d.classList.toggle('active', i === index));
    }

    function prev() { index = (index - 1 + slides.length) % slides.length; update(); }
    function next() { index = (index + 1) % slides.length; update(); }
    function goTo(i) { index = i % slides.length; update(); }

    prevBtn.addEventListener('click', () => { prev(); resetAutoplay(); });
    nextBtn.addEventListener('click', () => { next(); resetAutoplay(); });

    // Клавиши влево/вправо
    root.addEventListener('keydown', (e) => {
        if(e.key === 'ArrowLeft') { prev(); resetAutoplay(); }
        if(e.key === 'ArrowRight') { next(); resetAutoplay(); }
    });

    // Пауза при наведении/фокусе
    root.addEventListener('mouseenter', pauseAutoplay);
    root.addEventListener('mouseleave', startAutoplay);
    root.addEventListener('focusin', pauseAutoplay);
    root.addEventListener('focusout', startAutoplay);

    function startAutoplay() {
        if(autoplayId) return;
        autoplayId = setInterval(() => { next(); }, AUTOPLAY_INTERVAL);
    }
    function pauseAutoplay() { if(autoplayId) { clearInterval(autoplayId); autoplayId = null; } }
    function resetAutoplay() { pauseAutoplay(); startAutoplay(); }

    // Инициализация
    update();
    startAutoplay();

    // Обеспечим доступность: фокусируем контейнер, чтобы реагировать на клавиши
    root.tabIndex = 0;
})();
