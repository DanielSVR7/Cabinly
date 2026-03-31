<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Cabin;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $cabins = Cabin::query()->orderBy('name')->get();
        $bookings = Booking::query()
            ->with('cabin')
            ->latest()
            ->get();

        return view('admin.dashboard', compact('cabins', 'bookings'));
    }
}
