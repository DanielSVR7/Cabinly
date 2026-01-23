<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cabin;
use Illuminate\Http\Request;

class AdminCabinController extends Controller
{
    public function edit(Cabin $cabin)
    {
        return view('admin.cabins.edit', compact('cabin'));
    }

    public function update(Request $request, Cabin $cabin)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'location' => ['nullable', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:1000'],
            'capacity' => ['required', 'integer', 'min:1', 'max:20'],
            'price_per_night' => ['required', 'numeric', 'min:0'],
            'is_active' => ['required', 'boolean'],
        ]);

        $cabin->update($validated);

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Данные домика обновлены.');
    }
}
