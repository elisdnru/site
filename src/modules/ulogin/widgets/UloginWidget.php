<?php

namespace app\modules\ulogin\widgets;

use yii\base\Widget;

class UloginWidget extends Widget
{
    private static $once = false;

    private array $params = [
        'display' => 'panel',
        'fields' => 'first_name,last_name,email,photo',
        'providers' => 'vkontakte,twitter,facebook,google,yandex',
        'hidden' => 'other',
        'redirect' => '',
        'logout_url' => '/logout'
    ];

    public function run(): string
    {
        if (self::$once) {
            return '';
        }
        self::$once = true;
        return $this->render('uloginWidget', $this->params);
    }

    public function setParams($params): void
    {
        $this->params = array_merge($this->params, $params);
    }
}
