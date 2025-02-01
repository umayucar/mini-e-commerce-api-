<?php

namespace Tests\Unit;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected ProductRepositoryInterface $productRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productRepository = app(ProductRepositoryInterface::class);
    }

    public function test_can_get_all_products()
    {
        Product::factory()->count(3)->create();

        $products = $this->productRepository->getAll();

        $this->assertCount(3, $products);
    }
}
