<x-app-layout>
    <x-slot name="title">Edit Address</x-slot>
    <x-slot name="pageTitle">Edit {{ ucfirst($address->type) }} Address</x-slot>

    <div class="bg-white shadow-md rounded-lg p-6 border border-gray-100">
        <form method="POST" action="{{ route('user.addresses.update', $address->type) }}">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label for="type" class="block text-gray-700 font-medium mb-2">Address Type</label>
                    <input type="text" name="type" id="type" value="{{ $address->type }}" class="w-full p-2 border rounded-lg bg-gray-100" readonly>
                </div>
                <div>
                    <label for="street" class="block text-gray-700 font-medium mb-2">Street</label>
                    <input type="text" name="street" id="street" value="{{ old('street', $address->street) }}" class="w-full p-2 border rounded-lg @error('street') border-red-500 @enderror">
                    @error('street')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="city" class="block text-gray-700 font-medium mb-2">City</label>
                    <input type="text" name="city" id="city" value="{{ old('city', $address->city) }}" class="w-full p-2 border rounded-lg @error('city') border-red-500 @enderror">
                    @error('city')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="state" class="block text-gray-700 font-medium mb-2">State</label>
                    <input type="text" name="state" id="state" value="{{ old('state', $address->state) }}" class="w-full p-2 border rounded-lg @error('state') border-red-500 @enderror">
                    @error('state')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="postal_code" class="block text-gray-700 font-medium mb-2">Postal Code</label>
                    <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', $address->postal_code) }}" class="w-full p-2 border rounded-lg @error('postal_code') border-red-500 @enderror">
                    @error('postal_code')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="country" class="block text-gray-700 font-medium mb-2">Country</label>
                    <input type="text" name="country" id="country" value="{{ old('country', $address->country) }}" class="w-full p-2 border rounded-lg @error('country') border-red-500 @enderror">
                    @error('country')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary-dark">Update Address</button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>