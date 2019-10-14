<?php

namespace app\components\behaviors;

use CBehavior;
use Yii;

class JsInitBehavior extends CBehavior
{
    public function initJsDefaults(): void
    {
        Yii::app()->clientScript->registerMetaTag(Yii::app()->request->csrfToken, 'csrf-token');
    }
}
