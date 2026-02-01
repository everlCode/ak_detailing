<?php

namespace App\Http\Controllers;

use App\Models\BookingRequest;
use App\Models\Setting;
use App\Mail\BookingRequestMail;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class BookingRequestController extends Controller
{
    /**
     * Store a newly created booking request.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'service_id' => 'required|exists:services,id',
            'phone' => 'required|string',
        ]);

        try {
            // нормализуем телефон: убираем все нецифры
            $digits = preg_replace('/\D+/', '', $data['phone']);
            if (strlen($digits) === 10) {
                // если пользователь ввел 10 цифр, добавим ведущую 7
                $digits = '7' . $digits;
            }
            // заменить 8 в начале на 7
            if (strpos($digits, '8') === 0) {
                $digits = '7' . substr($digits, 1);
            }

            // проверим ожидаемую длину
            if (!preg_match('/^7\d{10}$/', $digits)) {
                return $request->expectsJson()
                    ? response()->json(['status' => 'error', 'message' => 'Неверный формат телефона', 'errors' => ['phone' => ['Неверный формат телефона']]], 422)
                    : redirect()->back()->withErrors(['phone' => 'Неверный формат телефона']);
            }

            $booking = BookingRequest::create([
                'name' => $data['name'],
                'service_id' => $data['service_id'],
                'phone' => $digits,
            ]);

            // Отправляем уведомление на email(ы) из настроек
            $emailsRaw = Setting::get('booking_emails', '');
            $emails = array_filter(array_map('trim', explode(',', $emailsRaw)));

            // валидируем email-адреса
            $validEmails = [];
            foreach ($emails as $e) {
                if (filter_var($e, FILTER_VALIDATE_EMAIL)) {
                    $validEmails[] = $e;
                } else {
                    Log::warning('Invalid booking email in settings: ' . $e);
                }
            }

            // если нет адресов в настройках, используем почту из config
            if (empty($validEmails)) {
                $from = config('mail.from.address');
                if ($from) {
                    $validEmails[] = $from;
                }
            }

            if (!empty($validEmails)) {
                try {
                    Mail::to($validEmails)->send(new BookingRequestMail($booking));
                } catch (\Throwable $e) {
                    Log::error('Failed to send booking email: ' . $e->getMessage());
                }
            }

        } catch (\Throwable $e) {
            Log::error('BookingRequest store error: ' . $e->getMessage());

            if ($request->expectsJson()) {
                return response()->json(['status' => 'error', 'message' => 'Не удалось сохранить заявку'], 500);
            }

            return redirect()->back()->with('error', 'Не удалось сохранить заявку');
        }

        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'ok',
                'message' => 'Ваша заявка принята. Мы свяжемся с вами.',
                'data' => [
                    'id' => $booking->id,
                ],
            ]);
        }

        return redirect()->back()->with('success', 'Ваша заявка принята. Мы свяжемся с вами.');
    }
}
