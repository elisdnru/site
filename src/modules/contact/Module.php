<?php

namespace app\modules\contact;

use app\components\GroupUrlRule;
use app\modules\contact\models\Contact;
use app\components\system\WebModule;

class Module extends WebModule
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

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
            [
                'class' => GroupUrlRule::class,
                'prefix' => 'contact',
                'rules' => [
                    'captcha' => 'default/captcha',
                ],
            ],
        ];
    }
}
