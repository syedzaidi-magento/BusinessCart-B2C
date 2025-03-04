<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shelf;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class ShelfController extends Controller
{
    public function index()
    {
        $shelves = Shelf::with('warehouse')->get();
        return view('admin.shelves.index', compact('shelves'));
    }

    public function create()
    {
        $warehouses = Warehouse::all();
        return view('admin.shelves.create', compact('warehouses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'shelf_name' => 'required|string|max:255',
        ]);

        Shelf::create($request->all());
        return redirect()->route('admin.shelves.index')->with('success', 'Shelf created successfully.');
    }

    public function edit(Shelf $shelf)
    {
        $warehouses = Warehouse::all();
        return view('admin.shelves.edit', compact('shelf', 'warehouses'));
    }

    public function update(Request $request, Shelf $shelf)
    {
        $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'shelf_name' => 'required|string|max:255',
        ]);

        $shelf->update($request->all());
        return redirect()->route('admin.shelves.index')->with('success', 'Shelf updated successfully.');
    }
}
