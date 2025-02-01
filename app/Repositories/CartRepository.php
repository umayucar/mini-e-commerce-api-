<?php

namespace App\Repositories;

use App\Events\CartTotalCalculated;
use App\Interfaces\CartRepositoryInterface;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\JsonResponse;

class CartRepository implements CartRepositoryInterface
{
    public function createCart(?int $userId): JsonResponse
    {
        $cart = Cart::where('user_id', $userId)->first();

        if (!$cart) {
            $cart = Cart::create(['user_id' => $userId]);
            $message = 'Yeni sepet oluşturuldu!';
        } else {
            $message = 'Zaten bir sepetiniz var!';
        }

        return response()->json([
            'message' => $message,
            'data' => $cart
        ]);
    }

    public function addItem(int $cartId, int $productId, int $quantity = 1): JsonResponse
    {
        $cart = Cart::find($cartId);

        if (!$cart) {
            return response()->json(['message' => 'Sepet bulunamadı!'], 404);
        }

        $cartItem = $cart->items()->where('product_id', $productId)->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $quantity);
            $message = 'Ürün miktarı güncellendi!';
        } else {
            $cartItem = $cart->items()->create([
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
            $message = 'Ürün sepete eklendi!';
        }

        return response()->json([
            'message' => $message,
            'data' => $cartItem
        ]);
    }


    public function getTotal(int $cartId): float
    {
        $cart = Cart::find($cartId);

        if (!$cart || $cart->items->isEmpty()) {
            return 0;
        }

        $total = $cart->items->sum(function ($cartItem) {
            return $cartItem->quantity * $cartItem->product->price;
        });

        event(new CartTotalCalculated($cart));

        return $total;
    }
}
