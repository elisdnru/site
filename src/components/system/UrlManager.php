<?php

namespace app\components\system;

use CUrlManager;

class UrlManager extends CUrlManager
{
    public function createUrl($route, $params = [], $ampersand = '&'): string
    {
        $url = parent::createUrl($route, $params, $ampersand);
        return $this->fixPathSlashes($url);
    }

    protected function fixPathSlashes(string $url): string
    {
        return preg_replace('|\%2F|i', '/', $url);
    }
}
