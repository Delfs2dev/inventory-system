<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Sale;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Basic stats
        $totalCategories = Category::count();
        $totalProducts   = Product::count();
        $latestProducts  = Product::with('category')->latest()->take(5)->get();

        // Top Selling Products this month
        $topSelling = Sale::with('product')
            ->selectRaw('product_id, SUM(quantity) as total_quantity')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->take(5)
            ->get();

        // Products count per category (for Pie Chart)
        $categories = Category::withCount('products')->get();

        return view('dashboard', compact(
            'totalCategories',
            'totalProducts',
            'latestProducts',
            'topSelling',
            'categories'
        ));
    }
}
