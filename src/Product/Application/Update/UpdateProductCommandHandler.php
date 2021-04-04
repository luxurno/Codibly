<?php

declare(strict_types=1);

namespace App\Product\Application\Update;

use App\Core\MessageHandler\CommandHandlerInterface;
use App\Product\Domain\Exception\NotFoundProductException;
use App\Product\Domain\Repository\ProductRepository;
use App\Product\Infrastructure\Persistence\DoctrineProductRepository;

class UpdateProductCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private DoctrineProductRepository $doctrineProductRepository,
        private ProductRepository $productRepository
    ) { }

    public function __invoke(UpdateProductCommand $command)
    {
        $product = $this->productRepository->findOneBy([
            'id' => $command->getProductId()->getId()
        ]);

        if (null === $product) {
            throw NotFoundProductException::createMessage(
                $command->getProductId()->getId()
            );
        }

        $product->setName($command->getProductName()->getName());
        $product->setPrice($command->getProductPrice()->getPrice());

        $this->doctrineProductRepository->saveProduct($product);
    }
}
