<?php

namespace App\Interfaces;

use Illuminate\Support\Collection;

interface ProductRepositoryInterface
{
    public function getAll(): Collection;
}
