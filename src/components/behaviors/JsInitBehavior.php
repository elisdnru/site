<?php

namespace app\components\behaviors;

use CBehavior;
use Yii;

class JsInitBehavior extends CBehavior
{
    public function initJsDefaults(): void
    {
        Yii::$app->view->registerMetaTag(['name' => 'csrf-token', 'content' => Yii::app()->request->csrfToken]);
    }
}
