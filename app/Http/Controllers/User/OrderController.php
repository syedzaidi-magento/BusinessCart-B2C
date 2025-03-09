<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please log in to view your orders.');
        }

        $orders = Order::where('user_id', auth()->id())
            ->orderBy('placed_at', 'desc') // Most recent first
            ->get();

        return view('user.orders.index', compact('orders'));
    }


}