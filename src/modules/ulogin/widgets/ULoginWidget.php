<?php

declare(strict_types=1);

namespace app\modules\ulogin\widgets;

use yii\base\Widget;

final class ULoginWidget extends Widget
{
    public string $display = 'panel';
    public string $redirect = '';

    private static bool $once = false;

    public function run(): string
    {
        if (self::$once) {
            return '';
        }

        self::$once = true;

        return $this->render('ULogin', [
            'display' => $this->display,
            'fields' => 'first_name,last_name,email,photo',
            'providers' => 'vkontakte,twitter,facebook,google,yandex',
            'hidden' => 'other',
            'redirect' => $this->redirect,
        ]);
    }
}
