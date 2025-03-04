<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttributeKey;
use Illuminate\Http\Request;

class AttributeKeyController extends Controller
{
    // Define supported model types
    private $modelTypes = [
        'Product' => 'Product',
        'User' => 'User',
        'Order' => 'Order',
        'Inventory' => 'Inventory',
    ];

    public function index()
    {
        $keys = AttributeKey::all();
        return view('admin.attribute_keys.index', compact('keys'));
    }

    public function create()
    {
        $modelTypes = $this->modelTypes;
        return view('admin.attribute_keys.create', compact('modelTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'model_type' => 'required|in:' . implode(',', array_keys($this->modelTypes)),
            'key_name' => 'required|string|max:255',
            'data_type' => 'required|in:string,integer,boolean',
            'is_required' => 'boolean',
        ]);

        AttributeKey::create($request->all());
        return redirect()->route('admin.attribute-keys.index')->with('success', 'Attribute key created.');
    }

    public function edit(AttributeKey $attributeKey)
    {
        $modelTypes = $this->modelTypes;
        return view('admin.attribute_keys.edit', compact('attributeKey', 'modelTypes'));
    }

    public function update(Request $request, AttributeKey $attributeKey)
    {
        $request->validate([
            'model_type' => 'required|in:' . implode(',', array_keys($this->modelTypes)),
            'key_name' => 'required|string|max:255',
            'data_type' => 'required|in:string,integer,boolean',
            'is_required' => 'boolean',
        ]);

        $attributeKey->update($request->all());
        return redirect()->route('admin.attribute-keys.index')->with('success', 'Attribute key updated.');
    }

    public function destroy(AttributeKey $attributeKey)
    {
        $attributeKey->delete();
        return redirect()->route('admin.attribute-keys.index')->with('success', 'Attribute key deleted.');
    }
}