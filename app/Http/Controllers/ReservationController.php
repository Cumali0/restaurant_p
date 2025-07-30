<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;

class ReservationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'datetime' => 'required|date',
            'people' => 'required|integer|min:1',
            'message' => 'nullable|string',
        ]);

        Reservation::create($validated);

        return redirect()->back()->with('success', 'Rezervasyonunuz başarıyla alındı!');
    }
}
