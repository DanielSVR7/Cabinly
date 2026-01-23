<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Cabin;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class CabinController extends Controller
{
    public function index()
    {
        $cabins = Cabin::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('cabins.index', compact('cabins'));
    }

    public function show(Cabin $cabin)
    {
        if (! $cabin->is_active) {
            abort(404);
        }

        $bookings = Booking::query()
            ->where('cabin_id', $cabin->id)
            ->where('status', '!=', Booking::STATUS_CANCELLED)
            ->orderBy('check_in')
            ->get();

        $occupiedHours = [];

        foreach ($bookings as $booking) {
            $start = $booking->check_in_at
                ? $booking->check_in_at->copy()
                : $booking->check_in->copy()->setTime(14, 0);
            $end = $booking->check_out_at
                ? $booking->check_out_at->copy()
                : $booking->check_out->copy()->setTime(12, 0);
            $end = $end->addHour();

            if ($end->lessThanOrEqualTo($start)) {
                continue;
            }

            $period = CarbonPeriod::create($start, '1 hour', $end->copy()->subHour());

            foreach ($period as $slot) {
                $dateKey = Carbon::instance($slot)->format('Y-m-d');
                $hourKey = Carbon::instance($slot)->format('H:i');
                $occupiedHours[$dateKey][$hourKey] = true;
            }
        }

        $occupiedHours = collect($occupiedHours)
            ->map(fn ($hours) => collect($hours)->keys()->sort()->values()->all())
            ->toArray();

        $hourSlots = ['14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00', '22:00'];
        $dayStatuses = [];

        foreach ($occupiedHours as $date => $hours) {
            $overlap = array_values(array_intersect($hours, $hourSlots));

            if (empty($overlap)) {
                continue;
            }

            $dayStatuses[$date] = count($overlap) === count($hourSlots) ? 'full' : 'partial';
        }

        return view('cabins.show', compact('cabin', 'occupiedHours', 'dayStatuses'));
    }
}
