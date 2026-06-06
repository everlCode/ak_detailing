<div class="contact-block">
    <div class="container">
        <div class="section-heading">
            <h2>Контакты</h2>
            <span class="section-heading__line"></span>
        </div>
        <div class="contact-grid">
            <div class="contact-image">
                <img src="{{ asset($settings['contact_image'] ?? 'images/car.webp') }}" alt="Контакты A.K detailing">
            </div>
            <div class="contact-info">
                <h3>Свяжитесь с нами</h3>
                <p class="contact-sub">Записывайтесь на услуги быстро и удобно — по телефону или в Telegram.</p>

                @if(!empty($settings['address']))
                <div class="contact-item">
                    <span class="contact-item__icon contact-item__icon--address">
                        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                        </svg>
                    </span>
                    <div>
                        <div class="contact-item__label">Адрес</div>
                        <div class="contact-item__value">{{ $settings['address'] }}</div>
                        <a class="contact-item__link" href="/contacts">Мы на карте →</a>
                    </div>
                </div>
                @endif

                @if(!empty($settings['phone']))
                <div class="contact-item">
                    <span class="contact-item__icon contact-item__icon--phone">
                        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1-9.4 0-17-7.6-17-17 0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.3 0 .7-.2 1L6.6 10.8z"/>
                        </svg>
                    </span>
                    <div>
                        <div class="contact-item__label">Телефон</div>
                        <div class="contact-item__value">
                            <a href="tel:{{ preg_replace('/[^+0-9]/', '', $settings['phone']) }}">
                                {{ \App\Models\Setting::formatPhone($settings['phone']) ?? $settings['phone'] }}
                            </a>
                        </div>
                    </div>
                </div>
                @endif

                @if(!empty($settings['telegram']))
                @php
                    $tg = trim($settings['telegram']);
                    $tgHref = preg_match('#^https?://#i', $tg) ? $tg : 'https://t.me/' . ltrim($tg, '@');
                @endphp
                <div class="contact-item">
                    <span class="contact-item__icon contact-item__icon--telegram">
                        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.96 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
                        </svg>
                    </span>
                    <div>
                        <div class="contact-item__label">Telegram</div>
                        <div class="contact-item__value">
                            <a href="{{ $tgHref }}" target="_blank" rel="noopener">{{ $tg }}</a>
                        </div>
                    </div>
                </div>
                @endif

                @if(!empty($settings['vk_link']))
                @php
                    $vk = trim($settings['vk_link']);
                    $vkHref = preg_match('#^https?://#i', $vk) ? $vk : 'https://' . $vk;
                @endphp
                <div class="contact-item">
                    <span class="contact-item__icon contact-item__icon--vk">
                        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M15.07 2H8.93C3.33 2 2 3.33 2 8.93v6.14C2 20.67 3.33 22 8.93 22h6.14C20.67 22 22 20.67 22 15.07V8.93C22 3.33 20.67 2 15.07 2m2.96 13.5h-1.72c-.65 0-.85-.52-2.01-1.69c-1.01-1-1.46-1.13-1.71-1.13c-.35 0-.45.1-.45.58v1.54c0 .41-.13.66-1.22.66c-1.8 0-3.8-1.09-5.2-3.12C4.31 9.5 3.8 7.5 3.8 7.07c0-.25.1-.48.58-.48h1.72c.43 0 .6.2.76.66c.84 2.34 2.25 4.4 2.83 4.4c.22 0 .32-.1.32-.65V9.13c-.07-1.17-.68-1.27-.68-1.69c0-.2.17-.41.43-.41h2.71c.37 0 .5.2.5.63v3.4c0 .37.16.5.27.5c.22 0 .4-.13.8-.53c1.24-1.39 2.13-3.52 2.13-3.52c.12-.25.32-.48.75-.48h1.72c.52 0 .63.27.52.63c-.22 1.04-2.34 4.01-2.34 4.01c-.19.31-.26.45 0 .8c.19.26.8.8 1.21 1.29c.75.85 1.33 1.57 1.48 2.07c.17.49-.08.74-.57.74"/>
                        </svg>
                    </span>
                    <div>
                        <div class="contact-item__label">ВКонтакте</div>
                        <div class="contact-item__value">
                            <a href="{{ $vkHref }}" target="_blank" rel="noopener">
                                {{ preg_replace('@https?://(www\.)?@', '', $vk) }}
                            </a>
                        </div>
                    </div>
                </div>
                @endif

                <div class="contact-actions">
                    @if(!empty($settings['phone']))
                        <a class="btn btn-primary" href="tel:{{ preg_replace('/[^+0-9]/', '', $settings['phone']) }}">
                            Позвонить
                        </a>
                    @endif
                    @if(!empty($settings['telegram']))
                        <a class="btn btn-outline" href="{{ $tgHref }}" target="_blank">
                            Написать в Telegram
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
