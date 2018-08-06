<?php

class ContactModule extends DWebModule
{
    public function init()
    {
        parent::init();

        $this->setImport([
            'application.modules.contact.models.*',
        ]);
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
        Yii::import('application.modules.contact.models.Contact');

        $messages = Contact::model()->count('status=' . Contact::STATUS_NEW);

        return [
            ['label' => 'Сообщения' . ($messages ? ' (' . $messages . ')' : ''), 'url' => ['/contact/contactAdmin/index'], 'icon' => 'message.png'],
        ];
    }

    public static function rules()
    {
        return [
            'contact/captcha' => 'contact/default/captcha',
        ];
    }

    public function install()
    {
        Yii::app()->config->add([
            [
                'param' => 'CONTACT.SEND_ADMIN_EMAILS',
                'label' => 'Уведомлять администратора по Email',
                'value' => '1',
                'type' => 'checkbox',
                'default' => '1',
            ],
        ]);

        return parent::install();
    }

    public function uninstall()
    {
        Yii::app()->config->delete([
            'COMMENT.SEND_REPLY_EMAILS',
        ]);

        return parent::uninstall();
    }
}
