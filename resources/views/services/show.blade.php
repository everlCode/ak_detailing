@extends('layouts.app')

@section('title', $service->name)

@section('content')
    <section class="services-section service-page">
        <div class="container">
            <h1>{{ $service->name }} в Кирове</h1>
            <div class="service-card">
                <div class="service-image">
                    <img src="{{ asset('/images/car.jpg') }}" alt="{{ $service->name }}">
                </div>

                <div class="service-meta">
                    <div class="price">Цена: <strong>{{ number_format($service->price, 2, ',', ' ') }} ₽</strong></div>
                    <a href="tel:+71234567890" class="btn primary">Записаться</a>
                </div>

                <div class="service-description">
                    {!! nl2br(e($service->description)) !!}
                </div>
            </div>
        </div>
    </section>

    {{-- Контакты (reuse partial) --}}
    @include('partials.contact-block')

@endsection
