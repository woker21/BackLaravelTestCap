<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            ['sku' => '000001', 'name' => 'BV Lean leather ankle boots', 'category' => 'boots', 'price' => 89000],
            ['sku' => '000002', 'name' => 'BV Lean leather ankle boots', 'category' => 'boots', 'price' => 99000],
            ['sku' => '000003', 'name' => 'Ashlington leather ankle boots', 'category' => 'boots', 'price' => 71000],
            ['sku' => '000004', 'name' => 'Naima embellished suede sandals', 'category' => 'sandals', 'price' => 79500],
            ['sku' => '000005', 'name' => 'Nathane leather sneakers', 'category' => 'sneakers', 'price' => 59000],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
