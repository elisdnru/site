<?php

declare(strict_types=1);

namespace app\components;

final class FilenameEscaper
{
    public static function escape(string $name): string
    {
        return Transliterator::translit(str_replace(['..', '~', '"', '\'', ':'], '_', $name));
    }
}
