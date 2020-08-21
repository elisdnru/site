<?php

namespace app\components;

class FileNameFilter
{
    public static function escape(string $name): string
    {
        return Transliterator::translit(str_replace(['..', '~', '"', '"', '/', ':'], '', $name));
    }
}
