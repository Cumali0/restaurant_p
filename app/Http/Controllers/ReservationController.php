<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;

class ReservationController extends Controller
{
    // Rezervasyonları listeleme sayfası (GET /dashboard/reservations)
    public function index()
    {
        $reservations = Reservation::orderBy('datetime', 'desc')->get();
        return view('admin.reservations.index', compact('reservations'));
    }

    // Yeni rezervasyon ekleme (POST /dashboard/reservations)
    public function store(Request $request)
    {
        // Validasyon ekle (isteğe bağlı)
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'datetime' => 'required|date',
            'people' => 'required|integer|min:1',
            'message' => 'nullable|string',
        ]);

        Reservation::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'datetime' => $request->datetime,
            'people' => $request->people,
            'message' => $request->message,
            'status' => 'pending',  // yeni rezervasyon başlangıçta 'pending'
        ]);

        return redirect()->route('reservations.index')->with('success', 'Rezervasyon başarıyla eklendi.');
    }

    // Rezervasyonu onaylama (POST /dashboard/reservations/{id}/approve)
    public function approve($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->status = 'approved';
        $reservation->save();

        return redirect()->route('reservations.index')->with('success', 'Rezervasyon onaylandı.');
    }

    // Rezervasyonu silme (DELETE /dashboard/reservations/{id})
    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        return redirect()->route('reservations.index')->with('success', 'Rezervasyon silindi.');
    }
}
