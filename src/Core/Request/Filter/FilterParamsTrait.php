<?php

declare(strict_types=1);

namespace App\Core\Request\Filter;

trait FilterParamsTrait
{
    private function filterRequestParams(array $array): array
    {
        return array_filter($array);
    }
}
