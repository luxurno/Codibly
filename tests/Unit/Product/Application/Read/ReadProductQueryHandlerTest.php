<?php

declare(strict_types=1);

namespace App\Tests\Unit\Product\Application\Read;

use App\Product\Application\Read\ReadProductQuery;
use App\Product\Application\Read\ReadProductQueryHandler;
use App\Product\Domain\Repository\ProductRepository;
use PHPUnit\Framework\TestCase;

class ReadProductQueryHandlerTest extends TestCase
{
    private const ID = 1;

    public function testHandle(): void
    {
        $readProductQuery = new ReadProductQuery(self::ID);

        $productRepository = $this->createMock(ProductRepository::class);
        $productRepository->expects(self::once())
            ->method('findOneBy')
            ->with(['id' => self::ID]);

        $readProductQueryHandler = new ReadProductQueryHandler($productRepository);
        $readProductQueryHandler($readProductQuery);
    }
}
