<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Stock;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $month = Carbon::now();

        $todaySales = Sale::where('status', 'completed')
            ->whereDate('sale_date', $today)
            ->sum('total_amount');

        $monthlySales = Sale::where('status', 'completed')
            ->whereMonth('sale_date', $month->month)
            ->whereYear('sale_date', $month->year)
            ->sum('total_amount');

        $lowStockProducts = Stock::where('quantity', '<=', Product::pluck('min_stock'))
            ->with('product')
            ->limit(10)
            ->get();

        $recentSales = Sale::with('customer', 'items')
            ->latest()
            ->limit(5)
            ->get();

        $totalCustomers = Customer::where('is_active', true)->count();
        $totalProducts = Product::where('is_active', true)->count();

        return view('dashboard.index', [
            'todaySales' => $todaySales,
            'monthlySales' => $monthlySales,
            'lowStockProducts' => $lowStockProducts,
            'recentSales' => $recentSales,
            'totalCustomers' => $totalCustomers,
            'totalProducts' => $totalProducts,
        ]);
    }
}
