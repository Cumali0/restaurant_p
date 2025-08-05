<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Table;
use Carbon\Carbon;

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
        // Masaları sırala, 'name' alanına göre alalım
        $tables = Table::orderBy('name')->get();
        return view('admin.reservations.create', compact('tables'));
    }

    // Yeni rezervasyon ekleme (POST /dashboard/reservations)
    public function store(Request $request)
    {
        $request->validate([
            'table_id' => 'required|exists:tables,id',
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'datetime' => 'required|date_format:Y-m-d H:i',
            'people' => 'required|integer|min:1',
            'message' => 'nullable|string',
        ]);

        $datetime = Carbon::createFromFormat('Y-m-d H:i', $request->datetime);

        // Çalışma saatleri kontrolü
        $day = $datetime->dayOfWeek;
        $time = $datetime->format('H:i');

        if ($day === 0) { // Pazar
            if ($time < '10:00' || $time > '20:00') {
                return back()->withErrors(['datetime' => 'Pazar günleri rezervasyonlar 10:00 - 20:00 saatleri arasında yapılabilir.'])->withInput();
            }
        } else { // Pazartesi - Cumartesi
            if ($time < '09:00' || $time > '21:00') {
                return back()->withErrors(['datetime' => 'Rezervasyonlar 09:00 - 21:00 saatleri arasında yapılabilir.'])->withInput();
            }
        }

        // Aynı masa ve tarih/saat için çakışma kontrolü
        $exists = Reservation::where('table_id', $request->table_id)
            ->where('datetime', $request->datetime)
            ->where('status', 'reserved')
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

    // AJAX: Seçilen datetime için masa uygunluk durumu (boş/dolu)
    public function tablesAvailability(Request $request)
    {
        $datetime = $request->query('datetime');

        if (!$datetime) {
            return response()->json(['error' => 'Datetime parameter required'], 400);
        }

        $tables = Table::orderBy('name')->get();

        // Aynı datetime ve 'reserved' durumundaki rezervasyonları çek
        $bookedTableIds = Reservation::where('datetime', $datetime)
            ->where('status', 'reserved')
            ->pluck('table_id')
            ->toArray();

        $available = [];
        $booked = [];

        foreach ($tables as $table) {
            if (in_array($table->id, $bookedTableIds)) {
                $booked[] = ['id' => $table->id, 'name' => $table->name];
            } else {
                $available[] = ['id' => $table->id, 'name' => $table->name];
            }
        }

        return response()->json([
            'available' => $available,
            'booked' => $booked,
        ]);
    }
}
