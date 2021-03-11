<?php

declare(strict_types=1);

function env(string $name): string
{
    $value = getenv($name);

    if ($value === false) {
        throw new RuntimeException('Undefined env ' . $name);
    }

    return $value;
}
