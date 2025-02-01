<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCartItemRequest;
use App\Http\Requests\StoreCartRequest;
use App\Models\Cart;
use App\Services\CartService;

class CartController extends Controller
{

    public function __construct(private CartService $cartService) {}

    public function index()
    {
        return Cart::with('user', 'items')->get();
    }

    public function store(StoreCartRequest $request)
    {
        $userId = $request->input('user_id');
        return $this->cartService->createCart($userId);
    }


    public function add(StoreCartItemRequest $request, $cartId)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        return  $this->cartService->addItem($cartId, $productId,  $quantity);
    }

    public function total($cartId)
    {
        $total = $this->cartService->calculateTotal($cartId);

        if ($total == 0) {
            return response()->json(['message' => 'Sepet toplamı bulunamadı!'], 404);
        }

        return response()->json(['message' => 'Sepet toplamı hesaplandı!', 'total' => $total]);
    }
}
