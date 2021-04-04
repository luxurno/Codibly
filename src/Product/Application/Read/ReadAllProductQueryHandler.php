<?php

declare(strict_types=1);

namespace App\Product\Application\Read;

use App\Core\MessageHandler\QueryHandlerInterface;
use App\Product\Domain\Repository\ProductRepository;

class ReadAllProductQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private ProductRepository $productRepository
    ) { }

    public function __invoke(ReadAllProductQuery $readAllProductQuery): ?array
    {
        return $this->productRepository->findBy(
            $readAllProductQuery->getParams()
        );
    }
}
