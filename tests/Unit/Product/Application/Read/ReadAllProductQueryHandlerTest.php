<?php

declare(strict_types=1);

namespace App\Tests\Unit\Product\Application\Read;

use App\Product\Application\Read\ReadAllProductQuery;
use App\Product\Application\Read\ReadAllProductQueryHandler;
use App\Product\Domain\Repository\ProductRepository;
use PHPUnit\Framework\TestCase;

class ReadAllProductQueryHandlerTest extends TestCase
{
    private const PARAMS = ['name' => 'productName'];

    public function testHandle(): void
    {
        $readAllProductQuery = new ReadAllProductQuery(self::PARAMS);

        $productRepository = $this->createMock(ProductRepository::class);
        $productRepository->expects(self::once())
            ->method('findBy')
            ->with(self::PARAMS);

        $readAllProductQueryHandler = new ReadAllProductQueryHandler($productRepository);
        $readAllProductQueryHandler($readAllProductQuery);
    }
}
