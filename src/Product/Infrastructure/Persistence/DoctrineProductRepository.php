<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\Persistence;

use App\Product\Domain\Product;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineProductRepository
{
    public function __construct(
        private EntityManagerInterface $em
    ) { }

    public function saveProduct(Product $product): void
    {
        $this->em->persist($product);
        $this->em->flush();
    }
}
