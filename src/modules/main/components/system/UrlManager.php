<?php

namespace app\modules\main\components\system;

use CUrlManager;

class UrlManager extends CUrlManager
{
    public function createUrl($route, $params = [], $ampersand = '&')
    {
        $url = parent::createUrl($route, $params, $ampersand);
        return $this->fixPathSlashes($url);
    }

    protected function fixPathSlashes($url)
    {
        return preg_replace('|\%2F|i', '/', $url);
    }
}