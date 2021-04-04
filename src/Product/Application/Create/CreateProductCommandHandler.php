<?php

declare(strict_types=1);

namespace App\Product\Application\Create;

use App\Core\MessageHandler\CommandHandlerInterface;
use App\Product\Domain\Factory\ProductFactory;
use App\Product\Infrastructure\Persistence\DoctrineProductRepository;

class CreateProductCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ProductFactory $productFactory,
        private DoctrineProductRepository $doctrineProductRepository
    ) { }

    public function __invoke(CreateProductCommand $command)
    {
        $product = $this->productFactory->create();
        $product->setName($command->getProductName()->getName());
        $product->setPrice($command->getProductPrice()->getPrice());

        $this->doctrineProductRepository->saveProduct($product);
    }
}
