<?php
/**
 * @author ElisDN <mail@elisdn.ru>
 * @link http://www.elisdn.ru
 */
class DUrlRulesHelper
{
    protected static $data = array();

    public static function import($moduleName)
    {
        if($moduleName && Yii::app()->hasModule($moduleName))
        {
            if (!isset(self::$data[$moduleName]))
            {
                if (array() !== $rules = Yii::app()->moduleManager->rules($moduleName));
                {
                    $urlManager = Yii::app()->getUrlManager();
                    $urlManager->addRules($rules);
                }
                self::$data[$moduleName] = true;
            }
        }
    }
}