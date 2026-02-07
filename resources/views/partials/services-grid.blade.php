<section class="services-grid py-5">
    <div class="container">
        <h2 class="mb-4">Наши услуги</h2>
        <div class="row g-3">
            @forelse($services as $service)
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card h-100 service-card">
                        @php
                            $rawPath = $service->mainImage && $service->mainImage->path ? $service->mainImage->path : 'images/car.jpg';
                            $imgAlt = $service->mainImage && $service->mainImage->alt ? $service->mainImage->alt : $service->name;
                        @endphp

                        @if(!empty($rawPath))
                            <img src="{{ img($rawPath, 324, 324) }}" class="card-img-top optimized-img" alt="{{ $imgAlt }}">
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $service->name }}</h5>

                            @if(!empty($service->short_description))
                                <p class="card-text">{{ $service->short_description }}</p>
                            @endif

                            <div class="mt-auto d-flex justify-content-center">
                                <a href="{{ route('services.show', ['alias' => $service->alias]) }}" class="btn btn-outline-secondary custom btn-sm me-2">Подробнее</a>
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#bookingModal" data-bs-service="{{ $service->id }}">Записаться</button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12"><p>Услуг пока нет.</p></div>
            @endforelse
        </div>
    </div>
</section>

<div id="booking" style="position:relative; height:1px; width:1px; overflow:hidden; visibility:hidden;"></div>
