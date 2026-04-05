<?php

declare(strict_types=1);

namespace app;

use Webmozart\Assert\Assert;

/**
 * @template T of object
 * @param T|null $value
 * @return T
 */
function notNull(mixed $value): mixed
{
    Assert::notNull($value);

    return $value;
}
