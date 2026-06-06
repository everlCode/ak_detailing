<section class="services-section">
    <div class="container">
        <div class="section-heading">
            <h2>Наши услуги</h2>
            <span class="section-heading__line"></span>
        </div>
        <div class="services-grid">
            @forelse($services as $service)
                @php
                    $rawPath = $service->mainImage?->path ?: 'images/car.jpg';
                    $imgAlt  = $service->mainImage?->alt  ?: $service->name;
                @endphp
                <article class="svc-card">
                    <a href="{{ route('services.show', ['alias' => $service->alias]) }}" class="svc-card__img-wrap">
                        <img src="{{ img($rawPath, 640, 400) }}" alt="{{ $imgAlt }}" class="svc-card__img">
                        <div class="svc-card__img-overlay"></div>
                        @if(!empty($service->price) && $service->price > 0)
                            <span class="svc-card__price">от {{ number_format($service->price, 0, '.', ' ') }} ₽</span>
                        @endif
                    </a>
                    <div class="svc-card__body">
                        <h3 class="svc-card__title">
                            <a href="{{ route('services.show', ['alias' => $service->alias]) }}">{{ $service->name }}</a>
                        </h3>
                        @if(!empty($service->short_description))
                            <p class="svc-card__text">{{ $service->short_description }}</p>
                        @endif
                        <div class="svc-card__actions">
                            <a href="{{ route('services.show', ['alias' => $service->alias]) }}" class="svc-card__btn svc-card__btn--outline">Подробнее</a>
                            <button type="button" class="svc-card__btn svc-card__btn--primary"
                                    data-bs-toggle="modal" data-bs-target="#bookingModal"
                                    data-bs-service="{{ $service->id }}">Записаться</button>
                        </div>
                    </div>
                </article>
            @empty
                <p>Услуг пока нет.</p>
            @endforelse
        </div>
    </div>
</section>

<div id="booking" style="position:relative;height:1px;width:1px;overflow:hidden;visibility:hidden;"></div>
