<?php
/**
 * @author ElisDN <mail@elisdn.ru>
 * @link http://www.elisdn.ru
 */

class DLanguageUrlManager extends CUrlManager
{
    public function createUrl($route, $params=array(), $ampersand='&')
    {
        $url = parent::createUrl($route, $params, $ampersand);
        return DMultilangHelper::addLangToUrl($url);
    }
}
