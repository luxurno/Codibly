<?php

declare(strict_types=1);

namespace App\Tests\Unit\Product\Application\Create;

use App\Product\Application\Create\CreateProductCommand;
use App\Product\Application\Create\CreateProductCommandHandler;
use App\Product\Domain\Factory\ProductFactory;
use App\Product\Domain\Product;
use App\Product\Domain\ValueObject\ProductName;
use App\Product\Domain\ValueObject\ProductPrice;
use App\Product\Infrastructure\Persistence\DoctrineProductRepository;
use PHPUnit\Framework\TestCase;

class CreateProductCommandHandlerTest extends TestCase
{
    private const NAME = 'name';
    private const PRICE = 123;

    public function testHandle(): void
    {
        $createProductCommand = new CreateProductCommand(
            new ProductName(self::NAME),
            new ProductPrice(self::PRICE)
        );

        $product = $this->createMock(Product::class);
        $productFactory = $this->createMock(ProductFactory::class);
        $doctrineProductRepository = $this->createMock(DoctrineProductRepository::class);

        $productFactory->expects(self::once())
            ->method('create')
            ->willReturn($product);

        $doctrineProductRepository->expects(self::once())
            ->method('saveProduct')
            ->with(...[$product]);

        $createProductCommandHandler = new CreateProductCommandHandler(
            $productFactory,
            $doctrineProductRepository
        );

        $createProductCommandHandler($createProductCommand);
    }
}
