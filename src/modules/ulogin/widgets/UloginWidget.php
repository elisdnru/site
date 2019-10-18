<?php

namespace app\modules\ulogin\widgets;

use CWidget;

class UloginWidget extends CWidget
{
    private static $once = false;

    private $params = [
        'display' => 'panel',
        'fields' => 'first_name,last_name,email,photo',
        'providers' => 'vkontakte,twitter,facebook,google,yandex',
        'hidden' => 'other',
        'redirect' => '',
        'logout_url' => '/logout'
    ];

    public function run(): void
    {
        if (!self::$once) {
            $this->render('uloginWidget', $this->params);
            self::$once = true;
        }
    }

    public function setParams($params): void
    {
        $this->params = array_merge($this->params, $params);
    }
}
