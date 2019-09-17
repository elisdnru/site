<?php

namespace app\modules\main\components\helpers;

use Yii;

class SystemHelper
{
    public static function importRecursive($alias)
    {
        $dir = Yii::app()->file->set(Yii::getPathOfAlias($alias));

        if (is_array($dir->contents)) {
            foreach ($dir->contents as $filename) {
                $file = Yii::app()->file->set($filename);
                self::importRecursive($alias . '.' . $file->basename);
            }
        } else {
            if (preg_match('|^(.+)\\.php$|', $alias, $m)) {
                Yii::import($m[1]);
            }
        }
    }
}
