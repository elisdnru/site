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
        Yii::import('application.modules.callme.models.Callme');

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

    public function install()
    {
        Yii::app()->config->add(array(
            array(
                'param'=>'CALLME.SEND_ADMIN_EMAILS',
                'label'=>'Отправлять заказы звонка администратору по Email',
                'value'=>'1',
                'type'=>'checkbox',
                'default'=>'1',
            ),
        ));

        return parent::install();
    }

    public function uninstall()
    {
        Yii::app()->config->delete(array(
            'CALLME.SEND_ADMIN_EMAILS',
        ));

        return parent::uninstall();
    }
}
