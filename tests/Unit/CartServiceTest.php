<?php

namespace Tests\Unit;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use App\Services\CartService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartServiceTest extends TestCase
{
    use RefreshDatabase;

    protected CartService $cartService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->cartService = app(CartService::class);
    }


    // CartService methodları için testleri içerir. 

    public function test_can_create_a_cart()
    {
        $cart = $this->cartService->createCart(1);
        $this->assertDatabaseHas('carts', ['user_id' => 1]);
    }

    public function test_can_add_item_to_cart()
    {
        $user = User::factory()->create();

        $cart = Cart::create([
            'user_id' => $user->id,
        ]);

        $product = Product::factory()->create();

        $this->cartService->addItem($cart->id, $product->id, 3);

        $this->assertDatabaseHas('cart_items', [
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 3
        ]);
    }

    public function test_calculates_cart_total()
    {
        $user = User::factory()->create();

        $cart = Cart::create([
            'user_id' => $user->id,
        ]);

        $product = Product::factory()->create(['price' => 50]);

        $this->cartService->addItem($cart->id, $product->id, 2);
        $total = $this->cartService->calculateTotal($cart->id);

        $this->assertEquals(100, $total);
    }
}
