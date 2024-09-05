<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        
        if ($request->has('priceLessThan')) {
            $query->where('price', '<=', $request->priceLessThan);
        }

        
        $products = $query->get()->map(function($product) {
            return $this->applyDiscount($product);
        });

        
        return response()->json($products->take(5));
    }

    private function applyDiscount($product)
    {
        $discount = 0;

        
        if ($product->category == 'boots') {
            $discount = 30;
        }

        
        if ($product->sku == '000003') {
            $discount = max($discount, 15);  
        }

        
        if ($discount > 0) {
            $product->price = [
                'original' => $product->price,
                'final' => round($product->price * (1 - $discount / 100), 2),
                'discount_percentage' => "{$discount}%",
                'currency' => 'EUR',
            ];
        } else {
            $product->price = [
                'original' => $product->price,
                'final' => $product->price,
                'discount_percentage' => null,
                'currency' => 'EUR',
            ];
        }

        return $product;
    }
}
