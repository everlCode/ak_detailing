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
        ]);

        try {
            $booking = BookingRequest::create([
                'name' => $data['name'],
                'service_id' => $data['service_id'],
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
