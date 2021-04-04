<?php

declare(strict_types=1);

namespace App\Tests\Unit\Product\Infrastructure\Persistence;

use App\Product\Domain\Product;
use App\Product\Infrastructure\Persistence\DoctrineProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class DoctrineProductRepositoryTest extends TestCase
{
    public function testSaveProduct(): void
    {
        $em = $this->createMock(EntityManagerInterface::class);
        $product = $this->createMock(Product::class);

        $em->expects(self::once())
            ->method('persist')
            ->with(...[$product]);
        $em->expects(self::once())
            ->method('flush');

        $doctrineProductRepository = new DoctrineProductRepository($em);
        $doctrineProductRepository->saveProduct($product);
    }

}