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
        if ($this->_requestUri === null) {
            try {
                $this->_requestUri = DMultilangHelper::processLangInUrl(parent::getRequestUri());
            } catch (Exception $e) {
                $this->_requestUri = '';
            }
        }

        return $this->_requestUri;
    }

    public function getOriginalUrl()
    {
        return $this->getOriginalRequestUri();
    }

    private $_originalRequestUri;

    public function getOriginalRequestUri()
    {
        if ($this->_originalRequestUri == null) {
            $this->_originalRequestUri = DMultilangHelper::addLangToUrl($this->getRequestUri());
        }
        return $this->_originalRequestUri;
    }
}
