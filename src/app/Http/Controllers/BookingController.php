<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Cabin;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function store(Request $request, Cabin $cabin)
    {
        if (! $cabin->is_active) {
            abort(404);
        }

        $validated = $request->validate([
            'guest_name' => ['required', 'string', 'max:120'],
            'guest_email' => ['required', 'email', 'max:120'],
            'guest_phone' => ['nullable', 'string', 'max:30'],
            'check_in' => ['required', 'date'],
            'check_out' => ['required', 'date', 'after:check_in'],
            'guests_count' => ['required', 'integer', 'min:1', 'max:20'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        Booking::create([
            'cabin_id' => $cabin->id,
            'guest_name' => $validated['guest_name'],
            'guest_email' => $validated['guest_email'],
            'guest_phone' => $validated['guest_phone'] ?? null,
            'check_in' => $validated['check_in'],
            'check_out' => $validated['check_out'],
            'guests_count' => $validated['guests_count'],
            'notes' => $validated['notes'] ?? null,
            'status' => Booking::STATUS_PENDING,
        ]);

        return redirect()
            ->route('cabins.show', $cabin)
            ->with('success', 'Заявка получена. Мы свяжемся с вами для подтверждения бронирования.');
    }
}
