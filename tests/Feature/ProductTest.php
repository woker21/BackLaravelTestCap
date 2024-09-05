<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_products()
    {
        Product::factory()->create(['sku' => '000001', 'name' => 'Product 1', 'category' => 'boots', 'price' => 10000]);
        Product::factory()->create(['sku' => '000002', 'name' => 'Product 2', 'category' => 'sneakers', 'price' => 5000]);

        // Act: Llama a la API
        $response = $this->get('/api/products');

        $response->assertStatus(200);
        $response->assertJsonCount(2); 
    }
}
