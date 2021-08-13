<?php

declare(strict_types=1);

namespace app\components;

final class PaginationFormatter
{
    public static function appendix(int $page): string
    {
        return $page > 1 ? ' - Страница ' . $page : '';
    }
}
