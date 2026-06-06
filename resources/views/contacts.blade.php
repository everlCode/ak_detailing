@extends('layouts.app')

@section('title', 'Контакты — A.K Detailing Киров')

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
                        @if(!empty($settings['phone']))
                            <a href="tel:{{ preg_replace('/[^+0-9]/', '', $settings['phone']) }}" style="color:#0b5fff;">{{ \App\Models\Setting::formatPhone($settings['phone']) ?? $settings['phone'] }}</a>
                        @endif
                    </div>
                </div>

                <div class="mb-3" style="display:flex;gap:12px;align-items:flex-start;">
                    <div style="font-size:20px;">📍</div>
                    <div>
                        <div style="font-weight:600">Адрес</div>
                        @if(!empty($settings['address']))
                            <div>{{ $settings['address'] }}</div>
                        @endif
                    </div>
                </div>

                <div class="mb-3" style="display:flex;gap:12px;align-items:flex-start;">
                    <div style="font-size:20px;">💬</div>
                    <div>
                        <div style="font-weight:600">Группа ВКонтакте</div>
                        @if(!empty($settings['vk_link']))
                            <div><a href="{{ $settings['vk_link'] }}" target="_blank" rel="noopener" style="color:#0b5fff;">{{ preg_replace('@https?://(www\.)?@', '', $settings['vk_link']) }}</a></div>
                        @endif
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('home') }}" class="btn btn-outline" style="margin-right:8px;">На главную</a>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bookingModal">Записаться</button>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Подключаем partial с картой --}}
    @include('partials.map-block')
@endsection

@push('head')
<!-- Yandex Maps API -->
<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" defer></script>
@endpush

@push('scripts')
<script src="{{ asset('/js/map-widget.js') }}" defer></script>
@endpush
