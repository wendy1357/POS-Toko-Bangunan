<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function summary()
    {
        $today = Carbon::today();

        $totalSalesToday = Sale::whereDate('transaction_date', $today)->sum('total_amount');
        $transactionCountToday = Sale::whereDate('transaction_date', $today)->count();
        $totalProducts = Product::count();
        $totalCustomers = \App\Models\Customer::count();

        return response()->json([
            'total_sales_today' => $totalSalesToday,
            'transaction_count_today' => $transactionCountToday,
            'total_products' => $totalProducts,
            'total_customers' => $totalCustomers,
        ]);
    }
}