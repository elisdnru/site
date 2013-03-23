<?php

class ContactModule extends DWebModule
{
    public function init()
    {
        parent::init();

        $this->setImport(array(
            'contact.models.*',
        ));
    }

    public static function system()
    {
        return true;
    }

    public function getName()
    {
        return 'Обратная связь';
    }

    public static function notifications()
    {
        Yii::import('contact.models.Contact');

        $messages = Contact::model()->count('status=' . Contact::STATUS_NEW);

        return array(
            array('label'=>'Сообщения' . ($messages ?  ' (' . $messages . ')' : ''), 'url'=>array('/contact/contactAdmin/index'), 'icon'=>'message.png'),
        );
    }

    public static function rules()
    {
        return array(
            'contact/captcha'=>'contact/default/captcha',
        );
    }
}
