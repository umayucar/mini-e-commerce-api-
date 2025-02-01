<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    // Cart işlemleri için api responseları test edilmiştir.

    public function test_can_list_carts()
    {
        $user = User::factory()->create();

        $cart = Cart::create([
            'user_id' => $user->id,
        ]);

        $response = $this->getJson("/api/cart");

        $response->assertStatus(200)
            ->assertJson([
                [
                    "id" => $cart->id,
                    "user_id" => $user->id,
                    "user" => [
                        "id" => $user->id,
                        "name" => $user->name,
                        "email" => $user->email,
                    ],
                    "items" => [],
                ],
            ]);
    }


    public function test_can_create_a_cart()
    {
        $user = User::factory()->create();

        $response = $this->post('/api/cart', ['user_id' => $user->id]);

        $response->assertStatus(200);
    }

    public function test_can_add_item_to_cart()
    {
        $user = User::factory()->create();

        $cart = Cart::create([
            'user_id' => $user->id,
        ]);

        $product = Product::factory()->create();

        $response = $this->postJson("/api/cart/{$cart->id}/items", [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Ürün sepete eklendi!',
                'data' => [
                    'product_id' => $product->id,
                    'quantity' => 1,
                    'cart_id' => $cart->id,
                ],
            ]);
    }

    public function test_cart_required_fields()
    {
        $response = $this->post('api/cart');
        $response
            ->assertJson([
                "success" => false,
                "message" => "Validation errors",
                "data" => [
                    "user_id" => [
                        "Kullanıcı ID'si gereklidir."
                    ]
                ]
            ]);
    }
}
