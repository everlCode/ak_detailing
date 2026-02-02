<div class="contact-block">
    <div class="container">
        <h1>Контакты</h1>
        <div class="container contact-grid">
            <div class="contact-image">
                <img src="{{ asset('/images/car.jpg') }}" alt="Контакты A.K detailing">
            </div>
            <div class="contact-info">
                <h3>Свяжитесь с нами</h3>
                <p class="contact-sub">Записывайтесь на услуги быстро и удобно — по телефону или в Telegram.</p>

                <div class="contact-item">
                    <svg class="icon" width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M3 5a2 2 0 0 1 2-2h3l2 3h6a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5z" stroke="#0f172a" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <div>
                        <div class="label">Адрес</div>
                        <div class="value">@if(!empty($settings['address'])) {{ $settings['address'] }} @endif</div>
                    </div>
                </div>

                <div class="contact-item">
                    <svg class="icon" width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2A19.86 19.86 0 0 1 3 5.18 2 2 0 0 1 5 3h3a2 2 0 0 1 2 1.72c.12 1.05.36 2.07.7 3.03a2 2 0 0 1-.45 2.11L9.2 11.8a14.06 14.06 0 0 0 6.99 6.99l1.94-1.04a2 2 0 0 1 2.11-.45c.96.34 1.98.58 3.03.7A2 2 0 0 1 22 16.92z" stroke="#0f172a" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <div>
                        <div class="label">Телефон</div>
                        <div class="value">@if(!empty($settings['phone'])) <a href="tel:{{ preg_replace('/[^+0-9]/', '', $settings['phone']) }}">{{ \App\Models\Setting::formatPhone($settings['phone']) ?? $settings['phone'] }}</a> @endif</div>
                    </div>
                </div>

                <div class="contact-item">
                    <svg class="icon" width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M22 2L11 13" stroke="#0f172a" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M22 2l-7 20-4-9-9-4 20-7z" stroke="#0f172a" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <div>
                        <div class="label">Telegram</div>
                        <div class="value">
                            @if(!empty($settings['telegram']))
                                @php
                                    $tg = trim($settings['telegram']);
                                    $tgHref = $tg;
                                    if (!preg_match('#^https?://#i', $tg)) {
                                        // если хранится в виде @handle или handle — приводим к t.me
                                        $handle = ltrim($tg, '@');
                                        $tgHref = 'https://t.me/' . $handle;
                                    }
                                @endphp
                                <a href="{{ $tgHref }}" target="_blank" rel="noopener">{{ $tg }}</a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="contact-item">
                    <svg class="icon" width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.5 14.5c-.66.83-1.66 1.5-2.88 1.5-1.73 0-2.5-1.17-4.05-1.17-.7 0-1.03.39-2.05.39-1.44 0-2.68-1.17-3.36-1.82V12c.62.44 1.88 1.3 3.36 1.3.98 0 1.35-.39 2.05-.39 1.55 0 2.32 1.17 4.05 1.17 1.22 0 2.22-.67 2.88-1.5.25-.31.57-.5.57-.81 0-.33-.47-.49-.87-.49-.77 0-1.77.5-2.28.5-.77 0-1.02-.5-1.7-.5-.62 0-.99.33-1.7.33-1.34 0-2.07-.67-2.9-.67-1.23 0-1.9.83-2.9.83v3.17c.54.47 1.36 1.09 2.73 1.09 1.26 0 1.72-.72 2.64-.72.78 0 1.1.5 1.86.5.6 0 1.6-.7 2.5-.7 1.08 0 1.77.93 3.2.93 1.1 0 1.92-.55 2.85-1.3v-4.1c-.86-.38-1.68-.79-2.6-.79-1.42 0-1.96.48-2.95.48-.69 0-1.12-.5-1.8-.5-.75 0-1.1.6-1.9.6-.78 0-1.33-.5-2.1-.5-1.28 0-1.95.8-3.1.8-1.24 0-1.97-.8-3.2-.8v-1.1c1.16 0 1.53-.42 3.1-.42 1.04 0 1.54.36 2.26.36.95 0 1.3-.36 2.05-.36 1.05 0 1.94.67 3.1.67 1.2 0 1.93-.67 3.1-.67.8 0 1.33.42 2.1.42.6 0 1.1-.42 1.86-.42.66 0 1.1.33 1.86.33.72 0 1.26-.33 1.86-.33.66 0 1.1.33 1.86.33.66 0 1.1-.33 1.86-.33.66 0 1.1.33 1.86.33v3.4z" stroke="#0f172a" stroke-width="0" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <div>
                        <div class="label">ВКонтакте</div>
                        <div class="value">
                            @if(!empty($settings['vk_link']))
                                @php
                                    $vk = trim($settings['vk_link']);
                                    $vkHref = $vk;
                                    if (!preg_match('#^https?://#i', $vk)) {
                                        $vkHref = 'https://' . $vk;
                                    }
                                @endphp
                                <a href="{{ $vkHref }}" target="_blank" rel="noopener">{{ preg_replace('@https?://(www\.)?@', '', $vk) }}</a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="contact-actions">
                    @if(!empty($settings['phone']))
                        <a class="btn primary" href="tel:{{ preg_replace('/[^+0-9]/', '', $settings['phone']) }}">Позвонить</a>
                    @endif
                    @if(!empty($settings['telegram']))
                        @php
                            $tg = trim($settings['telegram']);
                            $tgHref = $tg;
                            if (!preg_match('#^https?://#i', $tg)) {
                                $handle = ltrim($tg, '@');
                                $tgHref = 'https://t.me/' . $handle;
                            }
                        @endphp
                        <a class="btn" href="{{ $tgHref }}" target="_blank">Написать в Telegram</a>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
