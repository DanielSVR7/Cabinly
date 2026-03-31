<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class AdminBookingController extends Controller
{
    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:pending,confirmed,cancelled'],
        ]);

        $booking->update($validated);

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Статус бронирования обновлен.');
    }
}
