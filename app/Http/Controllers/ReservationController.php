<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Table;

class ReservationController extends Controller
{
    // Rezervasyonları listeleme (GET /dashboard/reservations)
    public function index()
    {
        $reservations = Reservation::orderBy('datetime', 'desc')->get();
        return view('admin.reservations.index', compact('reservations'));
    }

    // Yeni rezervasyon formu (GET /dashboard/reservations/create)
    public function create()
    {
        // Masa listesini de gönderebiliriz form için, isteğe bağlı
        $tables = Table::orderBy('table_number')->get();
        return view('admin.reservations.create', compact('tables'));
    }

    // Yeni rezervasyon ekleme (POST /dashboard/reservations)
    public function store(Request $request)
    {
        $request->validate([
            'table_id' => 'required|exists:tables,id',        // Masanın seçilmiş olması önemli
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'datetime' => 'required|date',
            'people' => 'required|integer|min:1',
            'message' => 'nullable|string',
        ]);

        // Aynı masa ve tarih/saat için çakışma kontrolü (basit)
        $exists = Reservation::where('table_id', $request->table_id)
            ->where('datetime', $request->datetime)
            ->where('status', 'reserved') // sadece aktif rezervasyonlara bak
            ->exists();

        if ($exists) {
            return back()->withErrors(['table_id' => 'Seçilen masa o tarih ve saatte doludur!'])->withInput();
        }

        Reservation::create([
            'table_id' => $request->table_id,
            'name' => $request->name,
            'surname' => $request->surname,
            'datetime' => $request->datetime,
            'people' => $request->people,
            'message' => $request->message,
            'status' => 'reserved',
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
