<footer class="site-footer">
    <div class="container footer-grid">
        <div class="footer-brand">
            <a href="{{ url('/') }}" class="footer-logo">
                <img src="{{ asset('/images/logo.png') }}" alt="A.K detailing" />
            </a>
        </div>

        <div class="footer-contacts">
            <ul>
                <li class="footer-contact-item">
                    <span class="fc-label">Телефон:</span>
                    <a href="tel:+71234567890" class="fc-link">+7 (123) 456-78-90</a>
                </li>
                <li class="footer-contact-item">
                    <span class="fc-label">Telegram:</span>
                    <a href="https://t.me/ak_detailing" target="_blank" rel="noopener" class="fc-link">@ak_detailing</a>
                </li>
                <li class="footer-contact-item">
                    <span class="fc-label">Адрес:</span>
                    <span class="fc-link">г. Москва, ул. Примерная, 12</span>
                </li>
            </ul>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <small>© {{ date('Y') }} A.K detailing — все права защищены</small>
        </div>
    </div>
</footer>

