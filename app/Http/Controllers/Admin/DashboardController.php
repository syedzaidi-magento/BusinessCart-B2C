<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\Store;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'total_users' => User::count(),
            'total_stores' => Store::count(),
            'products_in_stock' => Product::where('quantity', '>', 0)->count(),
            'products_out_of_stock' => Product::where('quantity', 0)->count(),
            'recent_orders' => Order::with('user')->orderBy('created_at', 'desc')->limit(5)->get(),
        ];
    
        return view('admin.dashboard.index', compact('stats'));
    }
}