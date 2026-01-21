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
                            <a href="#" class="submenu-toggle">Услуги</a>
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


                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        const items = document.querySelectorAll('.has-submenu');

                        items.forEach(item => {
                            const toggle = item.querySelector('.submenu-toggle');

                            // Клик — открыть / закрыть
                            toggle.addEventListener('click', (e) => {
                                e.preventDefault();
                                item.classList.toggle('open');
                            });

                            // Увели курсор — закрыть
                            item.addEventListener('mouseleave', () => {
                                item.classList.remove('open');
                            });
                        });
                    });

                </script>

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
        const dropdownToggles = document.querySelectorAll('.dropdown-toggle');

        dropdownToggles.forEach(toggle => {
            toggle.addEventListener('click', function (event) {
                event.stopPropagation();
                const dropdown = this.closest('.dropdown');
                dropdown.classList.toggle('active');
            });
        });

        document.addEventListener('click', function () {
            document.querySelectorAll('.dropdown').forEach(dropdown => {
                dropdown.classList.remove('active');
            });
        });
    });

    document.addEventListener('click', function (e) {
        const toggle = e.target.closest('.submenu-toggle');
        if (!toggle) return;

        e.preventDefault(); // ⬅️ критично

        const item = toggle.closest('.has-submenu');

        if (item.classList.has('open')) {
            item.classList.remove('open')
        } else {
            item.classList.add('open')
        }
    });


</script>
