<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Shelf;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $inventories = Inventory::with(['product', 'warehouse', 'shelf'])->paginate(10);
        return view('admin.inventories.index', compact('inventories'));
    }

    public function create()
    {
        $products = Product::all();
        $warehouses = Warehouse::all();
        $shelves = Shelf::all();
        return view('admin.inventories.create', compact('products', 'warehouses', 'shelves'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:sqlite_products.products,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'shelf_id' => 'required|exists:shelves,id',
            'quantity' => 'required|integer|min:0',
            'custom_attributes' => 'nullable|array',
        ]);

        Inventory::create($request->all());
        return redirect()->route('admin.inventories.index')->with('success', 'Inventory added successfully.');
    }

    public function edit(Inventory $inventory)
    {
        $products = Product::all();
        $warehouses = Warehouse::all();
        $shelves = Shelf::all();
        return view('admin.inventories.edit', compact('inventory', 'products', 'warehouses', 'shelves'));
    }

    public function update(Request $request, Inventory $inventory)
    {
        $request->validate([
            'product_id' => 'required|exists:sqlite_products.products,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'shelf_id' => 'required|exists:shelves,id',
            'quantity' => 'required|integer|min:0',
            'custom_attributes' => 'nullable|array',
        ]);

        $inventory->update($request->all());
        return redirect()->route('admin.inventories.index')->with('success', 'Inventory updated successfully.');
    }

    public function destroy(Inventory $inventory)
    {
        $inventory->delete();
        return redirect()->route('admin.inventories.index')->with('success', 'Inventory item deleted successfully.');
    }
}
