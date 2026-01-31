<?php

namespace App\Http\Controllers;

use App\Models\BookingRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

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
