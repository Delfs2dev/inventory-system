<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['name' => 'Laptop', 'price' => 35000, 'stock' => 10, 'category' => 'Electronics'],
            ['name' => 'Smartphone', 'price' => 15000, 'stock' => 20, 'category' => 'Electronics'],
            ['name' => 'Office Chair', 'price' => 3000, 'stock' => 15, 'category' => 'Furniture'],
            ['name' => 'Notebook', 'price' => 50, 'stock' => 200, 'category' => 'Stationery'],
            ['name' => 'T-Shirt', 'price' => 250, 'stock' => 100, 'category' => 'Clothing'],
        ];

        foreach ($products as $item) {
            $category = Category::where('name', $item['category'])->first();

            if ($category) {
                Product::create([
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'stock' => $item['stock'],
                    'category_id' => $category->id,
                ]);
            }
        }
    }
}
