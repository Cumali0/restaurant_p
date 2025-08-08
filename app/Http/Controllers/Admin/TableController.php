<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Table;
use Illuminate\Http\Request;
use App\Models\Reservation;

use Carbon\Carbon;

class TableController extends Controller
{


    public function index(Request $request)
    {
        $date = $request->input('date');
        $startTime = $request->input('start_time');
        $endTime = $request->input('end_time');

        $tables = Table::all();

        $reservations = collect();

        if ($date) {
            // Zaman aralığını oluştur
            if ($startTime && $endTime) {
                $startDateTime = \Carbon\Carbon::parse("$date $startTime");
                $endDateTime = \Carbon\Carbon::parse("$date $endTime");
            } elseif ($startTime && !$endTime) {
                $startDateTime = \Carbon\Carbon::parse("$date $startTime");
                $endDateTime = (clone $startDateTime)->addHours(2);
            } else {
                $startDateTime = \Carbon\Carbon::parse("$date 00:00:00");
                $endDateTime = \Carbon\Carbon::parse("$date 23:59:59");
            }

            $filteredReservations = \App\Models\Reservation::whereIn('status', ['reserved', 'approved'])
                ->where(function ($query) use ($startDateTime, $endDateTime) {
                    $query->where(function ($q) use ($startDateTime, $endDateTime) {
                        $q->whereBetween('datetime', [$startDateTime, $endDateTime])
                            ->orWhereBetween('end_datetime', [$startDateTime, $endDateTime])
                            ->orWhere(function ($q2) use ($startDateTime, $endDateTime) {
                                $q2->where('datetime', '<', $startDateTime)
                                    ->where('end_datetime', '>', $endDateTime);
                            });
                    });
                })
                ->orderBy('datetime')
                ->get();

            $reservations = $filteredReservations->groupBy('table_id');
        }

        // Doluluk kontrolü için dolu masa id’lerini al
        $reservedTables = $reservations->keys()->toArray();

        return view('admin.tables.index', compact('tables', 'reservations', 'reservedTables', 'date', 'startTime', 'endTime'));
    }




    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'capacity' => 'required|integer',
           // 'status' => 'required|in:available,booked',
            'floor' => 'nullable|integer',
        ]);

        Table::create($request->all());

        return redirect()->route('tables.index')->with('success', 'Masa başarıyla eklendi.');
    }

    public function update(Request $request, Table $table)
    {
        $request->validate([
            'name' => 'required',
            'capacity' => 'required|integer',
           // 'status' => 'required|in:available,booked',
            'floor' => 'nullable|integer',
        ]);

        $table->update($request->all());

        return redirect()->route('tables.index')->with('success', 'Masa başarıyla güncellendi.');
    }

    public function destroy(Table $table)
    {
        $table->delete();

        return redirect()->route('tables.index')->with('success', 'Masa başarıyla silindi.');
    }
}
