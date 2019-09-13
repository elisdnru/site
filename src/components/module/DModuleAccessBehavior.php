<?php

class DModuleAccessBehavior extends CBehavior
{
    public function moduleAllowed($module)
    {
        return Yii::app()->moduleManager->allowed($module);
    }
}
