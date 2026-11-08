<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use App\Models\Order_items;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function salesReport(Request $request)
    {
        $year = $request->input('year', date('Y'));

        
        $successStatus = 'paid'; 
        $totalRevenue = Orders::whereYear('created_at', $year)
            ->where('payment_status', $successStatus)
            ->sum('total_amount');

        $totalOrders = Orders::whereYear('created_at', $year)
            ->where('payment_status', $successStatus)
            ->count();

        $monthlySalesData = array_fill(1, 12, 0);
        $sales = Orders::selectRaw('MONTH(created_at) as month, SUM(total_amount) as total')
            ->whereYear('created_at', $year)
            ->where('payment_status', $successStatus)
            ->groupBy('month')
            ->get();

        foreach ($sales as $sale) {
            $monthlySalesData[$sale->month] = $sale->total;
        }

        $chartData = array_values($monthlySalesData);

        $topProducts = Order_items::select(
                'products.product_name',
                DB::raw('SUM(order_items.boughtquantity) as total_sold'),
                DB::raw('SUM(order_items.boughtquantity * products.product_price) as total_revenue')
            )
            ->join('products', 'order_items.product_id', '=', 'products.product_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.order_id')
            ->whereYear('orders.created_at', $year)
            ->where('orders.payment_status', $successStatus) 
            ->groupBy('products.product_id', 'products.product_name', 'products.product_price')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        $availableYears = Orders::selectRaw('YEAR(created_at) as year')
            ->groupBy('year')
            ->orderByDesc('year')
            ->pluck('year');

        if($availableYears->isEmpty()) {
            $availableYears = collect([date('Y')]);
        }

        return view('admin.reports.sales', compact('totalRevenue', 'totalOrders', 'chartData', 'year', 'availableYears', 'topProducts'));
    }
}
