<?php

declare(strict_types=1);

namespace app\modules\ulogin\widgets;

use yii\base\Widget;

final class ULoginWidget extends Widget
{
    private static bool $once = false;

    private array $params = [
        'display' => 'panel',
        'fields' => 'first_name,last_name,email,photo',
        'providers' => 'vkontakte,twitter,facebook,google,yandex',
        'hidden' => 'other',
        'redirect' => '',
        'logout_url' => '/logout',
    ];

    public function run(): string
    {
        if (self::$once) {
            return '';
        }
        self::$once = true;
        return $this->render('uLoginWidget', $this->params);
    }

    public function setParams(array $params): void
    {
        $this->params = array_merge($this->params, $params);
    }
}
