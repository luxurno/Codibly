<?php

declare(strict_types=1);

namespace App\Product\Domain\Factory;

use App\Product\Domain\Product;
use JetBrains\PhpStorm\Pure;

class ProductFactory
{
    #[Pure]
    public function create(): Product
    {
        return new Product();
    }
}
