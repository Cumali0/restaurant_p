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

    // Admin paneli için rezervasyonları listele
    public function index()
    {
        $reservations = Reservation::orderBy('datetime', 'desc')->get();
        return view('admin.reservations.index', compact('reservations'));
    }

    // Admin tarafından rezervasyonu onayla
    public function approve($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->status = 'approved';
        $reservation->save();

        return redirect()->back()->with('success', 'Rezervasyon onaylandı.');
    }

    // Admin tarafından rezervasyonu sil
    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        return redirect()->back()->with('success', 'Rezervasyon silindi.');
    }
}
