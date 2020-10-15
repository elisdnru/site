<?php

declare(strict_types=1);

namespace app\components\module\routes;

interface RoutesProvider
{
    public static function routes(): array;

    public static function routesPriority(): int;
}
