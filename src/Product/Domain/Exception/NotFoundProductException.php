<?php

declare(strict_types=1);

namespace App\Product\Domain\Exception;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NotFoundProductException extends NotFoundHttpException
{
    public static function createMessage(int $id): self
    {
        return new self(
            sprintf(
                'Not found Product with id: %s',
                $id
            )
        );
    }
}
