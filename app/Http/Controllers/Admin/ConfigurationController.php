<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Configuration;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    public function index($storeId = null)
    {
        $configs = [];
        foreach (Configuration::getPredefinedKeys() as $key) {
            $configs[$key] = [
                'definition' => Configuration::getDefinition($key),
                'value' => Configuration::getConfigValue($key, $storeId),
            ];
        }
        return view('admin.configurations.index', compact('configs', 'storeId'));
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

    public function update(Request $request, $storeId = null)
    {
        $submittedConfigs = $request->input('configs', []);

        foreach ($submittedConfigs as $key => $value) {
            // Validate that the key is a predefined configuration key
            if (!in_array($key, Configuration::getPredefinedKeys())) {
                continue; // Skip invalid keys
            }

            $definition = Configuration::getDefinition($key);
            // Handle type-specific value processing if needed
            $processedValue = $definition['type'] === 'json' ? json_encode($value) : $value;

            // Update the configuration if it exists
            Configuration::where('store_id', $storeId)
                ->where('group', $definition['group'])
                ->where('key', $key)
                ->update(['value' => $processedValue]);
        }

        return redirect()->back()->with('success', 'Configuration updated successfully.');
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