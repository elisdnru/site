<?php

use app\components\module\DUrlRulesHelper;

DUrlRulesHelper::import('ulogin');

class UloginWidget extends DWidget
{
    private static $once = false;

    private $params = [
        'display' => 'panel',
        'fields' => 'first_name,last_name,email,photo',
        'providers' => 'vkontakte,twitter,facebook,google',
        'hidden' => 'other',
        'redirect' => '',
        'logout_url' => '/logout'
    ];

    public function run()
    {
        if (!self::$once) {
            Yii::app()->clientScript->registerScriptFile('//ulogin.ru/js/ulogin.js', CClientScript::POS_END);
            $this->render('uloginWidget', $this->params);
            self::$once = true;
        }
    }

    public function setParams($params)
    {
        $this->params = array_merge($this->params, $params);
    }
}
