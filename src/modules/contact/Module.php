<?php

namespace app\modules\contact;

use app\components\GroupUrlRule;
use app\components\module\routes\UrlProvider;
use app\modules\contact\models\Contact;
use app\components\module\Module as Base;

class Module extends Base implements UrlProvider
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public function getName(): string
    {
        return 'Обратная связь';
    }

    public static function notifications(): array
    {
        $messages = Contact::find()->andWhere(['status' => Contact::STATUS_NEW])->count();

        return [
            ['label' => 'Сообщения' . ($messages ? ' (' . $messages . ')' : ''), 'url' => ['/contact/admin/contact/index'], 'icon' => 'message.png'],
        ];
    }

    public static function rules(): array
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

    public static function rulesPriority(): int
    {
        return 0;
    }
}
