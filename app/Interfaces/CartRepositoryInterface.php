<?php

namespace App\Interfaces;

use Illuminate\Http\JsonResponse;

interface CartRepositoryInterface
{
    public function createCart(?int $userId): JsonResponse;
    public function addItem(int $cartId, int $productId, int $quantity): JsonResponse;
    public function getTotal(int $cartId): float;
}
