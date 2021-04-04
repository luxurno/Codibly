<?php

declare(strict_types=1);

namespace App\Product\Application\Read;

class ReadAllProductQuery
{
    public function __construct(
        private array $params
    ) { }

    public function getParams(): array
    {
        return $this->params;
    }
}