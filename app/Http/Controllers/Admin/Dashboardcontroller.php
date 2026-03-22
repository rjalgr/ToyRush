<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;  

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users'    => User::where('role', 'user')->count(),
            'total_products' => Product::count(),
            'total_orders'   => Order::count(),
            'total_revenue'  => Order::where('payment_status', 'paid')->sum('total'),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'low_stock'      => Product::where('stock', '<=', 5)->count(),
        ];

        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        $topProducts = Product::withCount('orderItems')
            ->orderByDesc('order_items_count')
            ->take(5)
            ->get();

        $monthlySales = Order::where('payment_status', 'paid')
            ->selectRaw('MONTH(created_at) as month, SUM(total) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('admin.dashboard.index', compact('stats', 'recentOrders', 'topProducts', 'monthlySales'));
    }
}