<?php

/**
 * @author ElisDN <mail@elisdn.ru>
 * @link http://www.elisdn.ru
 */
class DFileHelper
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
        return DTextHelper::translit(str_replace(['./', '../', '~', '"', '"', '//', ':'], '', $name));
    }
}
