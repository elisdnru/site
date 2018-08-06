<?php

/**
 * @author ElisDN <mail@elisdn.ru>
 * @link http://www.elisdn.ru
 */
class DJsInitBehavior extends CBehavior
{
    public function initJsDefaults()
    {
        Yii::app()->clientScript->registerScript('constants', "
    function getCSRFToken(){ return '" . Yii::app()->request->csrfToken . "'; }
    function getVKApiId(){ return '" . (Yii::app()->config->has('GENERAL.SOCIAL_VK_APIID') ? Yii::app()->config->get('GENERAL.SOCIAL_VK_APIID') : '') . "'; }
    function getFBApiId(){ return ''; }
        ", CClientScript::POS_HEAD);
    }
}
