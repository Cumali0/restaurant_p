<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Table;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;  // << Bunu ekle

class ReservationController extends Controller
{
    // Rezervasyonları listeleme
    public function index()
    {
        $reservations = Reservation::orderBy('datetime', 'desc')->get();
        return view('admin.reservations.index', compact('reservations'));
    }

    // Yeni rezervasyon formu
    public function create()
    {
        $tables = Table::orderBy('name')->get();
        return view('admin.reservations.create', compact('tables'));
    }

    // Yeni rezervasyon ekleme
    public function store(Request $request)
    {
        $request->validate([
            'table_id' => 'required|exists:tables,id',
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'datetime' => 'required|date_format:Y-m-d H:i',
            'people' => 'required|integer|min:1',
            'message' => 'nullable|string',
            'duration' => 'nullable|integer|min:15|max:240',
        ]);

        $start = Carbon::createFromFormat('Y-m-d H:i', $request->datetime);
        $duration = (int) $request->input('duration', 90);  // kesin int cast

        $end = $start->copy()->addMinutes($duration);

        // Çalışma saatleri kontrolü
        $day = $start->dayOfWeek; // 0 = Pazar
        $time = $start->format('H:i');

        if ($day === 0) {
            if ($time < '10:00' || $time > '20:00') {
                return back()->withErrors(['datetime' => 'Pazar günleri rezervasyonlar 10:00 - 20:00 saatleri arasında yapılabilir.'])->withInput();
            }
        } else {
            if ($time < '09:00' || $time > '21:00') {
                return back()->withErrors(['datetime' => 'Rezervasyonlar 09:00 - 21:00 saatleri arasında yapılabilir.'])->withInput();
            }
        }

        // Çakışma kontrolü (rezervasyon zaman aralıkları örtüşüyor mu)
        $conflict = Reservation::where('table_id', $request->table_id)
            ->whereIn('status', ['reserved', 'approved'])
            ->where(function ($query) use ($start, $end) {
                $query->where(function ($q) use ($start, $end) {
                    $q->where('datetime', '<', $end)
                        ->where('end_datetime', '>', $start);
                });
            })
            ->exists();

        if ($conflict) {
            return back()->withErrors(['table_id' => 'Seçilen masa bu zaman aralığında doludur!'])->withInput();
        }

        // Yeni rezervasyon oluştur
        Reservation::create([
            'table_id' => $request->table_id,
            'name' => $request->name,
            'surname' => $request->surname,
            'datetime' => $start,
            'end_datetime' => $end,
            'people' => $request->people,
            'message' => $request->message,
            'status' => 'reserved',
        ]);

        return redirect()->route('reservation.thankyou')
            ->with('success', 'Rezervasyonunuz başarıyla oluşturuldu!');
    }

    // Rezervasyonu onaylama
    public function approve($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->status = 'approved';
        $reservation->save();

        return redirect()->route('reservations.index')->with('success', 'Rezervasyon onaylandı.');
    }

    // Rezervasyonu silme
    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        return redirect()->route('reservations.index')->with('success', 'Rezervasyon silindi.');
    }

    // AJAX: Tarih ve süreye göre masa uygunluk durumu (boş/dolu)
    public function tablesAvailability(Request $request)
    {
        $datetime = $request->query('datetime');
        $duration = (int) $request->query('duration', 90); // kesin int cast

        if (!$datetime) {
            return response()->json(['error' => 'Datetime parameter required'], 400);
        }

        $start = Carbon::parse($datetime);
        $end = $start->copy()->addMinutes($duration);

        // Tüm masalar
        $tables = Table::orderBy('name')->get();

        // Çakışan rezervasyonlar (zaman aralığı örtüşenler)
        $conflictingReservations = Reservation::whereIn('status', ['reserved', 'approved'])
            ->where(function ($query) use ($start, $end) {
                $query->where(function ($q) use ($start, $end) {
                    $q->where('datetime', '<', $end)
                        ->where('end_datetime', '>', $start);
                });
            })
            ->pluck('table_id')
            ->toArray();

        $available = [];
        $booked = [];

        foreach ($tables as $table) {
            if (in_array($table->id, $conflictingReservations)) {
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



    public function analytics()
    {
        // Son 30 gün içinde günlük rezervasyon sayıları
        $dailyReservations = Reservation::select(
            DB::raw('DATE(datetime) as date'),
            DB::raw('COUNT(*) as count')
        )
            ->where('datetime', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Son 12 ay içinde aylık rezervasyon sayıları
        $monthlyReservations = Reservation::select(
            DB::raw('DATE_FORMAT(datetime, "%Y-%m") as month'),
            DB::raw('COUNT(*) as count')
        )
            ->where('datetime', '>=', Carbon::now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month')
            ->get();




        // Verileri Blade'e gönderiyoruz
        return view('admin.analytics.index', compact('dailyReservations', 'monthlyReservations'));

    }
}
