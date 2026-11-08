<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Orders;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    
public function index(Request $request)
    {
        // pending
        $ordersCount = Orders::where('payment_status', 'pending_verification')->count();

        // total products
        $productsCount = Products::count();

        // total users 
        $customersCount = User::where('role', 'user')->count();

        return view('admin.dashboard.main', compact('ordersCount', 'productsCount', 'customersCount'));
    }

}
