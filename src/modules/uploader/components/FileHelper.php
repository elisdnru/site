<?php

namespace app\modules\uploader\components;

use app\modules\main\components\helpers\TextHelper;

class FileHelper
{
    public static function getRandomFileName($path, $extension = '')
    {
        $extension = $extension ? '.' . $extension : '';
        $path = $path ? $path . '/' : '';

        do {
            $name = md5(microtime() . rand(0, 9999));
            $file = $path . $name . $extension;
            usleep(1);
        } while (file_exists($file));

        return $name;
    }

    public static function escape($name)
    {
        return TextHelper::translit(str_replace(['./', '../', '~', '"', '"', '//', ':'], '', $name));
    }
}