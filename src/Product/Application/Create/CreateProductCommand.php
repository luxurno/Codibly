<?php

declare(strict_types=1);

namespace App\Product\Application\Create;

use App\Product\Domain\ValueObject\ProductName;
use App\Product\Domain\ValueObject\ProductPrice;

class CreateProductCommand
{
    public function __construct(
        private ProductName $productName,
        private ProductPrice $productPrice
    ) { }

    public function getProductName(): ProductName
    {
        return $this->productName;
    }

    public function getProductPrice(): ProductPrice
    {
        return $this->productPrice;
    }
}
