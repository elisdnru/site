<?php

namespace app\modules\main\components\behaviors;

use CBehavior;
use CClientScript;
use Yii;

class JsInitBehavior extends CBehavior
{
    public function initJsDefaults()
    {
        Yii::app()->clientScript->registerMetaTag(Yii::app()->request->csrfToken, 'csrf-token');
        Yii::app()->clientScript->registerMetaTag(Yii::app()->params['GENERAL.SOCIAL_VK_APIID'], 'vk-app-id');
        Yii::app()->clientScript->registerMetaTag('', 'fb-app-id');
    }
}
