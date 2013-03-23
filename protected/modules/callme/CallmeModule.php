<?php

class CallmeModule extends DWebModule
{
    public function init()
    {
        parent::init();

        $this->setImport(array(
            'callme.models.*',
        ));
    }

    public function getName()
    {
        return 'Заказ звонка';
    }

    public static function notifications()
    {
        Yii::import('callme.models.Callme');

        $messages = Callme::model()->count('readed = 0');

        return array(
            array('label'=>'Заказы звонков' . ($messages ?  ' (' . $messages . ')' : ''), 'url'=>array('/callme/callmeAdmin/index'), 'icon'=>'message.png'),
        );
    }

    public static function rules()
    {
        return array(
            'callme'=>'callme/default/index',
            'callme/captcha'=>'callme/default/captcha',
        );
    }
}
