<?php
/**
 * @author ElisDN <mail@elisdn.ru>
 * @link http://www.elisdn.ru
 */

class DLanguageHttpRequest extends CHttpRequest
{
    private $_requestUri;

    public function getRequestUri()
    {
        if($this->_requestUri === null)
        {
            $requestUri = ltrim(parent::getRequestUri(), '/');
            $domains = explode('/', $requestUri);
            if (in_array($domains[0], array_keys(Yii::app()->params['translatedLanguages'])))
            {
                $lang = array_shift($domains);
                Yii::app()->setLanguage($lang);
            }
            $this->_requestUri = '/' . implode('/', $domains);
        }

        return $this->_requestUri;
    }
}
