<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::all();
        return view('admin.warehouses.index', compact('warehouses'));
    }

    public function create()
    {
        return view('admin.warehouses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'nullable|string|max:255',
            'zip' => 'required|string|max:20',
            'country' => 'required|string|max:255',
            'contact_details' => 'nullable|string|max:500',
        ]);

        Warehouse::create($request->all());
        return redirect()->route('admin.warehouses.index')->with('success', 'Warehouse created successfully.');
    }

    public function edit(Warehouse $warehouse)
    {
        return view('admin.warehouses.edit', compact('warehouse'));
    }

    public function update(Request $request, Warehouse $warehouse)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'nullable|string|max:255',
            'zip' => 'required|string|max:20',
            'country' => 'required|string|max:255',
            'contact_details' => 'nullable|string|max:500',
        ]);

        $warehouse->update($request->all());
        return redirect()->route('admin.warehouses.index')->with('success', 'Warehouse updated successfully.');
    }
}
