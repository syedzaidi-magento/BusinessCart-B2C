<?php

namespace App\Http\Controllers\Admin;

use App\Models\CustomerGroup;
use Illuminate\Http\Request;

class CustomerGroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin'); // Assuming you have an admin middleware
    }

    public function index()
    {
        $groups = CustomerGroup::all();
        return view('admin.customer-groups.index', compact('groups'));
    }
}
