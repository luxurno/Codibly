<?php

declare(strict_types=1);

namespace App\Product\Domain\ValueObject;

class ProductPrice
{
    public function __construct(
        private ?int $price
    ) { }

    public function getPrice(): ?int
    {
        return $this->price;
    }
}
