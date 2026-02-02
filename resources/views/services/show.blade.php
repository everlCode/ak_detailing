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
                    <div class="price">Цена: от <strong>{{ number_format($service->price, 2, ',', ' ') }} ₽</strong></div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bookingModal" data-bs-service="{{ $service->name }}">Записаться</button>
                </div>

                <div class="service-description">
                    {!! $service->description !!}
                </div>
            </div>
        </div>
    </section>

    {{-- Контакты (reuse partial) --}}
    @include('partials.contact-block')

@endsection
