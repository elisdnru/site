<?php

DUrlRulesHelper::import('ulogin');

class UloginWidget extends DWidget
{
    //параметры по-умолчанию
    private $params = array(
        'display'       =>  'panel',
        'fields'        =>  'first_name,last_name,email,photo',
        'providers'     =>  'vkontakte,twitter,facebook,google',
        'hidden'        =>  'other',
        'redirect'      =>  '',
        'logout_url'    =>  '/logout'
    );

    public function run()
    {
        //подключаем JS скрипт
        Yii::app()->clientScript->registerScriptFile('http://ulogin.ru/js/ulogin.js', CClientScript::POS_HEAD);
        $this->render('uloginWidget', $this->params);
    }

    public function setParams($params)
    {
        $this->params = array_merge($this->params, $params);
    }
}