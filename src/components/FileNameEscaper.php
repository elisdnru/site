<?php

namespace app\components;

class FileNameEscaper
{
    public static function escape(string $name): string
    {
        return Transliterator::translit(str_replace(['..', '~', '"', '"', '/', ':'], '', $name));
    }
}
