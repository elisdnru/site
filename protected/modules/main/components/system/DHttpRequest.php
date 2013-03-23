<?php

/*
 * http://creative-territory.net/post/view/id/25/
 */

class DHttpRequest extends DLanguageHttpRequest
{
    public $noCsrfValidationUris = array();

    protected function normalizeRequest(){

        parent::normalizeRequest();

        if($_SERVER['REQUEST_METHOD'] != 'POST') return;

        //$route = Yii::app()->getUrlManager()->parseUrl($this);
        $route = $this->getPathInfo();

        if($this->enableCsrfValidation)
        {
            foreach($this->noCsrfValidationUris as $cr)
            {
                if(preg_match('#'.$cr.'#', $route))
                {
                    Yii::app()->detachEventHandler('onBeginRequest', array($this,'validateCsrfToken'));
                    Yii::trace('Route "'.$route.' passed without CSRF validation');
                    break; // found first route and break
                }
            }
        }
    }
}