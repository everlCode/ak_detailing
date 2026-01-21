<header itemscope="" itemtype="http://schema.org/Organization">
    <div class="container">
        <div class="menu">
            <div class="logotype">
                <a itemprop="url" href="/"><img itemprop="logo" src="/images/logo.png" title="Логотип" alt="Логотип"></a>
            </div>




            <div class="nav_bar">
                <nav class="menu">
                    <ul class="menu__list">
                        <li class="menu__item has-submenu">
                            <button type="button" class="dropdown-toggle" aria-expanded="false">Услуги <span class="arrow"></span></button>
                            <ul class="submenu">
                                @foreach ($services as $service)
                                    <li>
                                        <a class="dropdown-item" href="{{ route('services.show', ['alias' => $service->alias]) }}">
                                            {{ $service->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="menu__item">
                            <a href="/services">Примеры работ</a>
                        </li>
                        <li class="menu__item">
                            <a href="/sss">Контакты</a>
                        </li>
                        <li class="menu__item">
                            <a href="tel:+77001234567" class="contact-phone__link">
                                +7 700 123-45-67
                            </a>
                        </li>

                        <button>Записаться</button>
                    </ul>
                    <!-- Burger button for tablet/mobile -->
                    <div class="burger" aria-label="Toggle menu" role="button" tabindex="0">
                        <span class="bar"></span>
                        <span class="bar"></span>
                        <span class="bar"></span>
                    </div>
                </nav>

                <nav class="mobile-menu">
                    <ul class="mobile-menu__list">
                        <li class="mobile-menu__item">
                            <a href="#">Главная</a>
                        </li>

                        <li class="mobile-menu__item has-submenu">
                            <button type="button" class="submenu-toggle">
                                Услуги
                                <span class="arrow">▼</span>
                            </button>

                            <ul class="submenu">
                                <li><a href="#">Химчистка</a></li>
                                <li><a href="#">Полировка</a></li>
                                <li><a href="#">Защита кузова</a></li>
                            </ul>
                        </li>

                        <li class="mobile-menu__item">
                            <a href="#">Контакты</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</header>

<link rel="stylesheet" href="/css/app.css">

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Desktop toggles (main menu)
        document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
            toggle.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                const li = this.closest('.has-submenu');
                if (!li) return; // safety
                const isOpen = li.classList.toggle('open');
                this.setAttribute('aria-expanded', String(!!isOpen));
            });
        });

        // Mobile toggles (submenu inside mobile menu)
        document.querySelectorAll('.submenu-toggle').forEach(toggle => {
            toggle.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                const li = this.closest('.has-submenu');
                if (!li) return;
                const isOpen = li.classList.toggle('open');
                this.setAttribute('aria-expanded', String(!!isOpen));
            });
        });

        // Click outside closes any open submenu
        document.addEventListener('click', function (e) {
            if (e.target.closest('.has-submenu')) return;
            document.querySelectorAll('.has-submenu.open').forEach(li => {
                li.classList.remove('open');
                const btn = li.querySelector('.dropdown-toggle, .submenu-toggle');
                if (btn) btn.setAttribute('aria-expanded', 'false');
            });
        });

        // ESC closes
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('.has-submenu.open').forEach(li => {
                    li.classList.remove('open');
                    const btn = li.querySelector('.dropdown-toggle, .submenu-toggle');
                    if (btn) btn.setAttribute('aria-expanded', 'false');
                });
            }
        });
    });
</script>
