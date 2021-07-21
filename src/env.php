<?php

declare(strict_types=1);

function env(string $name, ?string $default = null): string
{
    $file = getenv($name . '_FILE');

    if ($file !== false) {
        return trim(file_get_contents($file));
    }

    $value = getenv($name);

    if ($value !== false) {
        return $value;
    }

    if ($default !== null) {
        return $default;
    }

    throw new RuntimeException('Undefined env ' . $name);
}
