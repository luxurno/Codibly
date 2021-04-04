<?php

declare(strict_types=1);

namespace App\Tests\Unit\Product\Application\Update;

use App\Product\Application\Update\UpdateProductCommand;
use App\Product\Application\Update\UpdateProductCommandHandler;
use App\Product\Domain\Exception\NotFoundProductException;
use App\Product\Domain\Product;
use App\Product\Domain\Repository\ProductRepository;
use App\Product\Domain\ValueObject\ProductId;
use App\Product\Domain\ValueObject\ProductName;
use App\Product\Domain\ValueObject\ProductPrice;
use App\Product\Infrastructure\Persistence\DoctrineProductRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class UpdateProductCommandHandlerTest extends TestCase
{
    private const ID = 1;
    private const NAME = 'nazwa';
    private const PRICE = 123;

    private DoctrineProductRepository|MockObject $doctrineProductRepository;
    private Product|MockObject $product;
    private ProductRepository|MockObject $productRepository;
    private UpdateProductCommand $updateProductCommand;

    protected function setUp(): void
    {
        $this->doctrineProductRepository = $this->createMock(DoctrineProductRepository::class);
        $this->product = $this->createMock(Product::class);
        $this->productRepository = $this->createMock(ProductRepository::class);
        $this->updateProductCommand = new UpdateProductCommand(
            new ProductId(self::ID),
            new ProductName(self::NAME),
            new ProductPrice(self::PRICE)
        );
    }

    public function testException(): void
    {
        $this->productRepository->expects(self::once())
            ->method('findOneBy')
            ->with(['id' => self::ID])
            ->willThrowException(new NotFoundProductException);

        $this->product->expects(self::never())
            ->method('setName');
        $this->product->expects(self::never())
            ->method('setPrice');

        $this->doctrineProductRepository->expects(self::never())
            ->method('saveProduct');

        $updateProductCommandHandler = new UpdateProductCommandHandler(
            $this->doctrineProductRepository,
            $this->productRepository
        );

        $this->expectException(NotFoundProductException::class);
        $updateProductCommandHandler($this->updateProductCommand);
    }

    public function testHandle(): void
    {
        $this->productRepository->expects(self::once())
            ->method('findOneBy')
            ->with(['id' => self::ID])
            ->willReturn($this->product);

        $this->product->expects(self::once())
            ->method('setName')
            ->with(...[self::NAME]);
        $this->product->expects(self::once())
            ->method('setPrice')
            ->with(...[self::PRICE]);

        $this->doctrineProductRepository->expects(self::once())
            ->method('saveProduct')
            ->with(...[$this->product]);

        $updateProductCommandHandler = new UpdateProductCommandHandler(
            $this->doctrineProductRepository,
            $this->productRepository
        );
        $updateProductCommandHandler($this->updateProductCommand);
    }
}
