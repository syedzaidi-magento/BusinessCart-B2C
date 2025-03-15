@extends('layouts.admin')

@section('title', 'Manage Configurations')
@section('page-title', 'Manage Configurations')

@section('content')
    <div class="min-h-screen bg-gray-100 py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 p-4 rounded-lg bg-green-50 text-green-700 border-l-4 border-green-500 transition-all duration-200">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-md rounded-lg border border-gray-200">
                <!-- Header -->
                <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800">Configuration List</h2>
                    <div>
                        <a href="{{ route('admin.configurations.editStorageDriver') }}" class="inline-flex items-center px-4 py-2 bg-primary text-white text-sm font-medium rounded-md hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors duration-200">
                            Edit Storage Driver
                        </a>
                    </div>
                </div>

                <!-- Configuration Form -->
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.configurations.update', $storeId) }}">
                        @csrf
                        @method('PATCH')

                        <!-- Grouped Configuration Sections -->
                        <div class="space-y-6">
                            @php
                                $groups = collect($configs)->groupBy(function ($config, $key) {
                                    return $config['definition']['group'];
                                });
                            @endphp

                            @foreach ($groups as $groupName => $groupConfigs)
                                <div class="bg-gray-50 rounded-lg shadow-sm border border-gray-200">
                                    <!-- Group Header -->
                                    <button type="button" class="w-full px-4 py-3 text-left bg-gray-100 border-b border-gray-200 rounded-t-lg focus:outline-none" data-toggle="collapse" data-target="#group-{{ $groupName }}">
                                        <h3 class="text-lg font-semibold text-gray-800">{{ ucwords(str_replace('_', ' ', $groupName)) }}</h3>
                                    </button>

                                    <!-- Group Content -->
                                    <div id="group-{{ $groupName }}" class="p-4 space-y-4">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            @foreach ($groupConfigs as $key => $config)
                                                <div class="flex flex-col">
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ $config['definition']['description'] }}</label>
                                                    @if ($config['definition']['type'] === 'boolean')
                                                        <input type="checkbox" name="configs[{{ $key }}]" value="1" {{ $config['value'] ? 'checked' : '' }} class="h-5 w-5 text-primary border-gray-300 rounded focus:ring-primary">
                                                    @elseif ($config['definition']['type'] === 'decimal')
                                                        <input type="number" step="0.01" name="configs[{{ $key }}]" value="{{ $config['value'] }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary sm:text-sm">
                                                    @else
                                                        <input type="text" name="configs[{{ $key }}]" value="{{ $config['value'] }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary sm:text-sm">
                                                    @endif
                                                    @error("configs.$key")
                                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Save Button -->
                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-primary text-white text-sm font-medium rounded-md hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors duration-200">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Simple JavaScript for Collapsible Sections -->
    <script>
        document.querySelectorAll('[data-toggle="collapse"]').forEach(button => {
            button.addEventListener('click', () => {
                const targetId = button.getAttribute('data-target');
                const target = document.querySelector(targetId);
                target.classList.toggle('hidden');
            });
        });
    </script>
@endsection