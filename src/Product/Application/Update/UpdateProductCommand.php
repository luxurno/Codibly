<?php

declare(strict_types=1);

namespace App\Product\Application\Update;

use App\Product\Domain\ValueObject\ProductId;
use App\Product\Domain\ValueObject\ProductName;
use App\Product\Domain\ValueObject\ProductPrice;

class UpdateProductCommand
{
    public function __construct(
        private ProductId $productId,
        private ProductName $productName,
        private ProductPrice $productPrice
    ) { }

    public function getProductId(): ProductId
    {
        return $this->productId;
    }

    public function getProductName(): ProductName
    {
        return $this->productName;
    }

    public function getProductPrice(): ProductPrice
    {
        return $this->productPrice;
    }
}
