<?php
/**
 * @author ElisDN <mail@elisdn.ru>
 * @link http://www.elisdn.ru
 */

class DModuleAccessBehavior extends CBehavior
{
    public function moduleAllowed($module)
    {
        return Yii::app()->moduleManager->allowed($module);
    }
}
