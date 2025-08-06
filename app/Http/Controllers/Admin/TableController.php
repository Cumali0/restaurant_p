<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    public function index()
    {
        $tables = Table::all();
        return view('admin.tables.index', compact('tables'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'capacity' => 'required|integer',
            'status' => 'required|in:available,booked',
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
            'status' => 'required|in:available,booked',
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
