<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Cabin;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function store(Request $request, Cabin $cabin)
    {
        if (! $cabin->is_active) {
            abort(404);
        }

        $validated = $request->validate([
            'booking_type' => ['required', 'string', 'in:daily,hourly'],
            'guest_name' => ['required', 'string', 'max:120'],
            'guest_email' => ['required', 'email', 'max:120'],
            'guest_phone' => ['nullable', 'string', 'max:30'],
            'check_in_date' => ['required', 'date'],
            'check_out_date' => ['required', 'date', 'after_or_equal:check_in_date'],
            'check_in_time' => ['nullable', 'date_format:H:i'],
            'check_out_time' => ['nullable', 'date_format:H:i'],
            'guests_count' => ['required', 'integer', 'min:1', 'max:20'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $bookingType = $validated['booking_type'];
        $checkInDate = Carbon::parse($validated['check_in_date'])->startOfDay();
        $checkOutDate = Carbon::parse($validated['check_out_date'])->startOfDay();

        $checkInAt = $checkInDate->copy();
        $checkOutAt = $checkOutDate->copy();

        if ($bookingType === Booking::TYPE_DAILY) {
            if ($checkOutDate->lessThanOrEqualTo($checkInDate)) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'check_out_date' => 'Дата выезда должна быть позже даты заезда.',
                    ]);
            }

            $checkInAt = $checkInDate->copy()->setTime(14, 0);
            $checkOutAt = $checkOutDate->copy()->setTime(12, 0);
        } else {
            if (empty($validated['check_in_time']) || empty($validated['check_out_time'])) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'check_in_time' => 'Укажите время заезда и выезда для почасовой аренды.',
                    ]);
            }

            if ($checkInDate->notEqualTo($checkOutDate)) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'check_out_date' => 'Почасовая аренда доступна только в пределах одного дня.',
                    ]);
            }

            $checkInAt = Carbon::parse($validated['check_in_date'] . ' ' . $validated['check_in_time']);
            $checkOutAt = Carbon::parse($validated['check_out_date'] . ' ' . $validated['check_out_time']);

            if ($checkOutAt->lessThanOrEqualTo($checkInAt)) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'check_out_time' => 'Время выезда должно быть позже времени заезда.',
                    ]);
            }

            if ($checkInAt->minute !== 0 || $checkOutAt->minute !== 0) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'check_in_time' => 'Выберите время начала и окончания с точностью до часа.',
                    ]);
            }

            $windowStart = $checkInAt->copy()->setTime(14, 0);
            $windowEnd = $checkInAt->copy()->setTime(23, 0);

            if ($checkInAt->lt($windowStart) || $checkOutAt->gt($windowEnd)) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'check_in_time' => 'Почасовая аренда доступна с 14:00 до 23:00.',
                    ]);
            }

            if ($checkInAt->diffInHours($checkOutAt) < 3) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'check_out_time' => 'Минимальная длительность почасовой аренды — 3 часа.',
                    ]);
            }
        }

        $checkInDateForStore = $checkInAt->copy()->startOfDay();
        $checkOutDateForStore = $checkOutAt->copy()->startOfDay();
        $cleaningEndsAt = $checkOutAt->copy()->addHour();

        $existingBookings = Booking::query()
            ->where('cabin_id', $cabin->id)
            ->where('status', '!=', Booking::STATUS_CANCELLED)
            ->get();

        $hasConflict = $existingBookings->contains(function (Booking $booking) use ($checkInAt, $cleaningEndsAt) {
            $existingStart = $booking->check_in_at
                ? $booking->check_in_at->copy()
                : $booking->check_in->copy()->setTime(14, 0);
            $existingEnd = $booking->check_out_at
                ? $booking->check_out_at->copy()
                : $booking->check_out->copy()->setTime(12, 0);
            $existingEnd = $existingEnd->addHour();

            return $existingStart->lt($cleaningEndsAt) && $existingEnd->gt($checkInAt);
        });

        if ($hasConflict) {
            return back()
                ->withInput()
                ->withErrors([
                    'check_in_date' => 'Домик уже забронирован на выбранный период. Выберите другое время.',
                ]);
        }

        Booking::create([
            'cabin_id' => $cabin->id,
            'booking_type' => $bookingType,
            'guest_name' => $validated['guest_name'],
            'guest_email' => $validated['guest_email'],
            'guest_phone' => $validated['guest_phone'] ?? null,
            'check_in' => $checkInDateForStore,
            'check_out' => $checkOutDateForStore,
            'check_in_at' => $checkInAt,
            'check_out_at' => $checkOutAt,
            'guests_count' => $validated['guests_count'],
            'notes' => $validated['notes'] ?? null,
            'status' => Booking::STATUS_CONFIRMED,
        ]);

        return redirect()
            ->route('cabins.show', $cabin)
            ->with('success', 'Бронирование подтверждено автоматически. Ждем вас в выбранные даты.');
    }
}
