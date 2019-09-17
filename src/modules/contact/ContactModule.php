<?php

namespace app\modules\contact;

use app\modules\contact\models\Contact;
use app\modules\main\components\system\WebModule;

class ContactModule extends WebModule
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
