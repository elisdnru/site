<?php
/**
 * @author ElisDN <mail@elisdn.ru>
 * @link http://www.elisdn.ru
 */

class DUrlManager extends DLanguageUrlManager
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
