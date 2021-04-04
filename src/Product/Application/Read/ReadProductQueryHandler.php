<?php

declare(strict_types=1);

namespace App\Product\Application\Read;

use App\Core\MessageHandler\QueryHandlerInterface;
use App\Product\Domain\Product;
use App\Product\Domain\Repository\ProductRepository;

class ReadProductQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private ProductRepository $productRepository
    ) { }

    public function __invoke(ReadProductQuery $query): ?Product
    {
        return $this->productRepository->findOneBy([
            'id' => $query->getId()
        ]);
    }
}
