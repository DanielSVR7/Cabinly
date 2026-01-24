<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cabin;
use Illuminate\Http\Request;

class AdminCabinController extends Controller
{
    public function create()
    {
        return view('admin.cabins.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'location' => ['nullable', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:1000'],
            'image' => ['nullable', 'image', 'max:5120'],
            'capacity' => ['required', 'integer', 'min:1', 'max:20'],
            'max_extra_guests' => ['required', 'integer', 'min:0', 'max:20'],
            'price_per_night' => ['required', 'numeric', 'min:0'],
            'price_per_hour' => ['required', 'numeric', 'min:0'],
            'extra_guest_price_per_night' => ['required', 'numeric', 'min:0'],
            'extra_guest_price_per_hour' => ['required', 'numeric', 'min:0'],
            'is_active' => ['required', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('cabins', 'public');
        }

        Cabin::create($validated);

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Домик добавлен.');
    }

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
            'image' => ['nullable', 'image', 'max:5120'],
            'capacity' => ['required', 'integer', 'min:1', 'max:20'],
            'max_extra_guests' => ['required', 'integer', 'min:0', 'max:20'],
            'price_per_night' => ['required', 'numeric', 'min:0'],
            'price_per_hour' => ['required', 'numeric', 'min:0'],
            'extra_guest_price_per_night' => ['required', 'numeric', 'min:0'],
            'extra_guest_price_per_hour' => ['required', 'numeric', 'min:0'],
            'is_active' => ['required', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('cabins', 'public');
        }

        $cabin->update($validated);

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Данные домика обновлены.');
    }
}
