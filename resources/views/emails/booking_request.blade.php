<p>Поступила новая заявка на запись</p>

<p><strong>Имя:</strong> {{ $booking->name }}</p>
<p><strong>Телефон:</strong> {{ $booking->phone }}</p>
@if($booking->service)
    <p><strong>Услуга:</strong> {{ $booking->service->name ?? $booking->service_id }}</p>
@endif
<p><small>Дата: {{ $booking->created_at }}</small></p>
