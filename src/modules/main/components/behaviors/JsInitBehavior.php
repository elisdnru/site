<?php

namespace app\modules\main\components\behaviors;

use CBehavior;
use CClientScript;
use Yii;

class JsInitBehavior extends CBehavior
{
    public function initJsDefaults()
    {
        Yii::app()->clientScript->registerScript('constants', "
    function getCSRFToken(){ return '" . Yii::app()->request->csrfToken . "'; }
    function getVKApiId(){ return '" . Yii::app()->params['GENERAL.SOCIAL_VK_APIID'] . "'; }
    function getFBApiId(){ return ''; }
        ", CClientScript::POS_HEAD);
    }
}
