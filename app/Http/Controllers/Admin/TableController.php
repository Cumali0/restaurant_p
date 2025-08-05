<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
public function index()
{
$tables = Table::orderBy('floor')->orderBy('name')->get();
return view('admin.tables.index', compact('tables'));
}

public function store(Request $request)
{
$request->validate([
'name' => 'required|string|max:255',
'capacity' => 'required|integer|min:1',
'status' => 'required|in:available,booked',
'floor' => 'nullable|integer',
]);

$data = $request->only(['name', 'capacity', 'status', 'floor']);
Table::create($data);

return redirect()->route('admin.tables.index')->with('success', 'Masa başarıyla eklendi.');
}

public function update(Request $request, Table $table)
{
$request->validate([
'name' => 'required|string|max:255',
'capacity' => 'required|integer|min:1',
'status' => 'required|in:available,booked',
'floor' => 'nullable|integer',
]);

$data = $request->only(['name', 'capacity', 'status', 'floor']);
$table->update($data);

return redirect()->route('admin.tables.index')->with('success', 'Masa başarıyla güncellendi.');
}

public function destroy(Table $table)
{
$table->delete();

return redirect()->route('admin.tables.index')->with('success', 'Masa başarıyla silindi.');
}
}
