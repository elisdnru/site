<?php

namespace app\components\module;

use Yii;

class DUrlRulesHelper
{
    protected static $data = [];

    public static function import($moduleName)
    {
        if ($moduleName && Yii::app()->hasModule($moduleName)) {
            if (!isset(self::$data[$moduleName])) {
                if ([] !== $rules = Yii::app()->moduleManager->rules($moduleName)) {
                    $urlManager = Yii::app()->getUrlManager();
                    $urlManager->addRules($rules);
                }
                self::$data[$moduleName] = true;
            }
        }
    }
}
