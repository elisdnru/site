<?php

namespace app\components\helpers;

class FileHelper
{
    public static function getRandomFileName($path, $extension = ''): string
    {
        $extension = $extension ? '.' . $extension : '';
        $path = $path ? $path . '/' : '';

        do {
            $name = md5(microtime() . random_int(0, 9999));
            $file = $path . $name . $extension;
            usleep(1);
        } while (file_exists($file));

        return $name;
    }

    public static function escape($name): string
    {
        return TextHelper::translit(str_replace(['..', '~', '"', '"', '/', ':'], '', $name));
    }
}