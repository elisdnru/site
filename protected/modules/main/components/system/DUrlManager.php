<?php
/**
 * @author ElisDN <mail@elisdn.ru>
 * @link http://www.elisdn.ru
 */

class DUrlManager extends CUrlManager
{
    public function createUrl($route, $params=array(), $ampersand='&')
    {
        $url = parent::createUrl($route, $params, $ampersand);
        $url = $this->fixPathSlashes($url);
        $url = DLanguageUrlHelper::normalize($url);
        return $url;
    }

    protected  function fixPathSlashes($url)
    {
        return preg_replace('|\%2F|i', '/', $url);
    }
}
