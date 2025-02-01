<?php

namespace App\Services;

use App\Interfaces\CartRepositoryInterface;
use Illuminate\Http\JsonResponse;

class CartService
{

    public function __construct(private CartRepositoryInterface $cartRepository) {}

    public function createCart(?int $userId): JsonResponse
    {
        return $this->cartRepository->createCart($userId);
    }

    public function addItem(int $cartId, int $productId, int $quantity): JsonResponse
    {
        return $this->cartRepository->addItem($cartId, $productId, $quantity);
    }

    public function calculateTotal(int $cartId): float
    {
        return $this->cartRepository->getTotal($cartId);
    }
}
