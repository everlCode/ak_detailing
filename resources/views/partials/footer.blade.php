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
                    @if(!empty($settings['phone']))
                        <a href="tel:{{ preg_replace('/[^+0-9]/', '', $settings['phone']) }}" class="fc-link">{{ \App\Models\Setting::formatPhone($settings['phone']) ?? $settings['phone'] }}</a>
                    @endif
                </li>
                <li class="footer-contact-item">
                    <span class="fc-label">Telegram:</span>
                    @if(!empty($settings['telegram']))
                        @php
                            $tg = trim($settings['telegram']);
                            $tgHref = $tg;
                            if (!preg_match('#^https?://#i', $tg)) {
                                $handle = ltrim($tg, '@');
                                $tgHref = 'https://t.me/' . $handle;
                            }
                        @endphp
                        <a href="{{ $tgHref }}" target="_blank" rel="noopener" class="fc-link">{{ $tg }}</a>
                    @endif
                </li>
                <li class="footer-contact-item">
                    <span class="fc-label">Адрес:</span>
                    @if(!empty($settings['address']))
                        <span class="fc-link">{{ $settings['address'] }}</span>
                    @endif
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
