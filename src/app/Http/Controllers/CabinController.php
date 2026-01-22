<?php

namespace App\Http\Controllers;

use App\Models\Cabin;

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

        return view('cabins.show', compact('cabin'));
    }
}
