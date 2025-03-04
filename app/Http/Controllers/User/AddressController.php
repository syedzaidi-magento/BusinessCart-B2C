<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AddressController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $addresses = $user->addresses;
        Log::debug('User Addresses: ' . $addresses->toJson());
        return view('user.addresses.index', compact('addresses'));
    }

    public function create()
    {
        return view('user.addresses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:shipping,billing',
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:255',
        ]);

        $user = auth()->user();
        $user->addresses()->updateOrCreate(
            ['type' => $request->type],
            $request->only('street', 'city', 'state', 'postal_code', 'country')
        );

        return redirect()->route('user.addresses.index')->with('success', 'Address created/updated successfully.');
    }

    public function edit(string $type)
    {
        $user = auth()->user();
        $address = $user->getAddressByType($type);
        if (!$address) {
            return redirect()->route('user.addresses.index')->with('error', 'Address not found.');
        }
        return view('user.addresses.edit', compact('address'));
    }

    public function update(Request $request, string $type)
    {
        $request->validate([
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:255',
        ]);

        $user = auth()->user();
        $address = $user->getAddressByType($type);
        if (!$address) {
            return redirect()->route('user.addresses.index')->with('error', 'Address not found.');
        }

        $address->update($request->only('street', 'city', 'state', 'postal_code', 'country'));

        return redirect()->route('user.addresses.index')->with('success', 'Address updated successfully.');
    }

    public function destroy(string $type)
    {
        $user = auth()->user();
        $address = $user->getAddressByType($type);
        if ($address) {
            $address->delete();
            return redirect()->route('user.addresses.index')->with('success', 'Address deleted successfully.');
        }
        return redirect()->route('user.addresses.index')->with('error', 'Address not found.');
    }
}