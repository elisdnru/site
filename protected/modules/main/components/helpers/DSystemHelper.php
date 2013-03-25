<?php
/**
 * @author ElisDN <mail@elisdn.ru>
 * @link http://www.elisdn.ru
 */
class DSystemHelper
{
    public static function importRecursive($alias)
    {
        $dir = Yii::app()->file->set(Yii::getPathOfAlias($alias));

        if (is_array($dir->contents))
        {
            foreach ($dir->contents as $filename)
            {
                $file = Yii::app()->file->set($filename);
                self::importRecursive($alias . '.' . $file->basename);
            }
        }
        else
        {
            if (preg_match('|^(.+)\\.php$|', $alias, $m)){
                Yii::import($m[1]);
            }
        }
    }
}
