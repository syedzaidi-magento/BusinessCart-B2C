<x-app-layout>
    <x-slot name="title">My Addresses</x-slot>
    <x-slot name="pageTitle">My Addresses</x-slot>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow-md rounded-lg p-6 border border-gray-100">
        <h2 class="text-xl font-bold mb-4">Your Addresses</h2>
        <a href="{{ route('user.addresses.create') }}" class="bg-primary text-white px-4 py-2 rounded-lg mb-4 inline-block">Add New Address</a>
        @if ($addresses->isNotEmpty())
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 text-left">Type</th>
                        <th class="px-4 py-2 text-left">Street</th>
                        <th class="px-4 py-2 text-left">City</th>
                        <th class="px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($addresses as $address)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ ucfirst($address->type) }}</td>
                            <td class="px-4 py-2">{{ $address->street }}</td>
                            <td class="px-4 py-2">{{ $address->city }}</td>
                            <td class="px-4 py-2">
                                <a href="{{ route('user.addresses.edit', $address->type) }}" class="text-primary hover:underline mr-2">Edit</a>
                                <form action="{{ route('user.addresses.destroy', $address->type) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-gray-500">No addresses found.</p>
        @endif
    </div>
</div>
</x-app-layout>