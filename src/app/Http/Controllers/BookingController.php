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

        $hasConflict = Booking::query()
            ->where('cabin_id', $cabin->id)
            ->where('status', '!=', Booking::STATUS_CANCELLED)
            ->where(function ($query) use ($validated) {
                $query
                    ->whereDate('check_in', '<', $validated['check_out'])
                    ->whereDate('check_out', '>', $validated['check_in']);
            })
            ->exists();

        if ($hasConflict) {
            return back()
                ->withInput()
                ->withErrors([
                    'check_in' => 'Домик уже забронирован на выбранные даты. Выберите другой период.',
                ]);
        }

        Booking::create([
            'cabin_id' => $cabin->id,
            'guest_name' => $validated['guest_name'],
            'guest_email' => $validated['guest_email'],
            'guest_phone' => $validated['guest_phone'] ?? null,
            'check_in' => $validated['check_in'],
            'check_out' => $validated['check_out'],
            'guests_count' => $validated['guests_count'],
            'notes' => $validated['notes'] ?? null,
            'status' => Booking::STATUS_CONFIRMED,
        ]);

        return redirect()
            ->route('cabins.show', $cabin)
            ->with('success', 'Бронирование подтверждено автоматически. Ждем вас в выбранные даты.');
    }
}
