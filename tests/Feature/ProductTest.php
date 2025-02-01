<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_products()
    {
        Product::factory()->count(10)->create();
        $response = $this->get('/api/products');

        $response->assertStatus(200)
            ->assertJsonCount(10);
    }
}
