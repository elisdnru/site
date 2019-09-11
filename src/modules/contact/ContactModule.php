<?php

namespace app\modules\contact;

use Contact;
use DWebModule;
use Yii;

class ContactModule extends DWebModule
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public function init()
    {
        parent::init();

        $this->setImport([
            'application.modules.contact.models.*',
        ]);
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
}
