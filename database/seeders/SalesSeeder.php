<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Sale;

class SalesSeeder extends Seeder
{
    public function run(): void
    {
        // kunin lahat ng products
        $products = Product::all();

        foreach ($products as $product) {
            // gagawa tayo ng 5 random sales per product
            for ($i = 0; $i < 5; $i++) {
                $qty = rand(1, 10); // 1 to 10 sold
                $total = $qty * $product->price;

                Sale::create([
                    'product_id'  => $product->id,
                    'quantity'    => $qty,
                    'total_price' => $total,
                    'created_at'  => now()->subDays(rand(0, 30)), // random date in last 30 days
                    'updated_at'  => now(),
                ]);
            }
        }
    }
}
