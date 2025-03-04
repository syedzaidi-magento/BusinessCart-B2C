<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Configuration;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    public function index()
    {
        $configurations = Configuration::all();
        return view('admin.configurations.index', compact('configurations'));
    }

    public function create()
    {
        return view('admin.configurations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|string|max:255',
            'value' => 'required|string',
            'description' => 'nullable|string',
        ]);

        Configuration::create($request->all());
        return redirect()->route('admin.configurations.index')->with('success', 'Configuration created successfully.');
    }

    public function edit(Configuration $configuration)
    {
        return view('admin.configurations.edit', compact('configuration'));
    }

    public function update(Request $request, Configuration $configuration)
    {
        $request->validate([
            'key' => 'required|string|max:255',
            'value' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $configuration->update($request->all());
        return redirect()->route('admin.configurations.index')->with('success', 'Configuration updated successfully.');
    }

    public function destroy(Configuration $configuration)
    {
        $configuration->delete();
        return redirect()->route('admin.configurations.index')->with('success', 'Configuration deleted successfully.');
    }

    public function editStorageDriver()
    {
        $config = Configuration::where('group', 'storage')->where('key', 'driver')->first() ?? new Configuration([
            'group' => 'storage',
            'key' => 'driver',
            'value' => 'local',
            'type' => 'string',
            'description' => 'Storage driver for product images (local or s3)',
        ]);
        return view('admin.configurations.edit_storage_driver', compact('config'));
    }
    
    public function updateStorageDriver(Request $request)
    {
        $request->validate([
            'value' => 'required|in:local,s3',
        ]);
    
        Configuration::updateOrCreate(
            ['group' => 'storage', 'key' => 'driver'],
            [
                'value' => $request->input('value'),
                'type' => 'string',
                'description' => 'Storage driver for product images (local or s3)',
            ]
        );
    
        return redirect()->route('admin.configurations.index')->with('success', 'Storage driver updated successfully.');
    }    
}