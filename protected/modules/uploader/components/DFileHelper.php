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
            $name = md5(microtime());
            $file = $path . $name . $extension;
            usleep(1);
        } while (file_exists($file));

        return $name;
    }

    public static function escape($name)
    {
        return DTextHelper::translit(str_replace(array('./', '../', '~', '"', '"', '//', ':'), '', $name));
    }
}
