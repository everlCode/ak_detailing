<?php

namespace Tests\Feature;

use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class BookingRequestTest extends TestCase
{
    use RefreshDatabase;

    private function makeService(): Service
    {
        return Service::create([
            'name'  => 'Тест',
            'alias' => 'test-service',
            'price' => 1000,
        ]);
    }

    // --- успешные сценарии ---

    public function test_stores_booking_and_returns_ok(): void
    {
        Mail::fake();
        $service = $this->makeService();

        $response = $this->postJson('/booking', [
            'name'       => 'Иван Иванов',
            'phone'      => '+7 (999) 123-45-67',
            'service_id' => $service->id,
        ]);

        $response->assertOk()->assertJson(['status' => 'ok']);
        $this->assertDatabaseHas('booking_requests', [
            'name'       => 'Иван Иванов',
            'phone'      => '79991234567',
            'service_id' => $service->id,
        ]);
    }

    public function test_normalizes_10_digit_phone(): void
    {
        Mail::fake();
        $service = $this->makeService();

        $this->postJson('/booking', [
            'name'       => 'Тест',
            'phone'      => '9161234567',
            'service_id' => $service->id,
        ])->assertOk();

        $this->assertDatabaseHas('booking_requests', ['phone' => '79161234567']);
    }

    public function test_normalizes_phone_starting_with_8(): void
    {
        Mail::fake();
        $service = $this->makeService();

        $this->postJson('/booking', [
            'name'       => 'Тест',
            'phone'      => '89161234567',
            'service_id' => $service->id,
        ])->assertOk();

        $this->assertDatabaseHas('booking_requests', ['phone' => '79161234567']);
    }

    public function test_sends_email_after_booking(): void
    {
        Mail::fake();
        $service = $this->makeService();

        $this->postJson('/booking', [
            'name'       => 'Тест',
            'phone'      => '+79161234567',
            'service_id' => $service->id,
        ])->assertOk();

        Mail::assertSent(\App\Mail\BookingRequestMail::class);
    }

    // --- валидация ---

    public function test_requires_name(): void
    {
        $service = $this->makeService();

        $this->postJson('/booking', [
            'phone'      => '+79161234567',
            'service_id' => $service->id,
        ])->assertUnprocessable()->assertJsonValidationErrors(['name']);
    }

    public function test_requires_phone(): void
    {
        $service = $this->makeService();

        $this->postJson('/booking', [
            'name'       => 'Тест',
            'service_id' => $service->id,
        ])->assertUnprocessable()->assertJsonValidationErrors(['phone']);
    }

    public function test_requires_valid_service_id(): void
    {
        $this->postJson('/booking', [
            'name'       => 'Тест',
            'phone'      => '+79161234567',
            'service_id' => 9999,
        ])->assertUnprocessable()->assertJsonValidationErrors(['service_id']);
    }

    public function test_rejects_invalid_phone_format(): void
    {
        $service = $this->makeService();

        $this->postJson('/booking', [
            'name'       => 'Тест',
            'phone'      => '123',
            'service_id' => $service->id,
        ])->assertUnprocessable()->assertJson(['status' => 'error']);
    }
}
