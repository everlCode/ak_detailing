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
                    <!-- Standard VK logo (Wikimedia) -->
                    <img class="icon vk-icon" src="https://upload.wikimedia.org/wikipedia/commons/2/21/VK.com-logo.svg" width="18" height="18" alt="ВКонтакте" />
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
