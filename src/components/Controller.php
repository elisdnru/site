<?php

namespace app\components;

use CController;
use CInlineAction;
use CWebModule;
use Yii;
use yii\web\Controller as Base;

abstract class Controller extends Base
{
    public function beforeAction($action): bool
    {
        Yii::app()->controller = new CController($this->id, new CWebModule($this->module->id, Yii::app()));
        Yii::app()->controller->action = new CInlineAction(Yii::app()->controller, $this->action->id);
        return parent::beforeAction($action);
    }
}
