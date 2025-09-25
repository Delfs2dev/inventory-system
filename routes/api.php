<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Models\Category;
use App\Models\Sale;

// Default
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// 📌 Products API
Route::get('/products', function () {
    return Product::with('category')->get();
});

Route::get('/products/{id}', function ($id) {
    return Product::with('category')->findOrFail($id);
});

// 📌 Categories API
Route::get('/categories', function () {
    return Category::with('products')->get();
});

Route::get('/categories/{id}', function ($id) {
    return Category::with('products')->findOrFail($id);
});

// 📌 Sales API
Route::get('/sales', function () {
    return Sale::with('product')->get();
});

Route::get('/sales/top', function () {
    return Sale::with('product')
        ->selectRaw('product_id, SUM(quantity) as total_quantity')
        ->whereMonth('created_at', now()->month)
        ->whereYear('created_at', now()->year)
        ->groupBy('product_id')
        ->orderByDesc('total_quantity')
        ->take(5)
        ->get();
});
