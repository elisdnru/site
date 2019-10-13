<?php

/*
 * http://creative-territory.net/post/view/id/25/
 */

namespace app\components\system;

use CHttpRequest;
use Yii;

class HttpRequest extends CHttpRequest
{
    public $noCsrfValidationUris = [];

    protected function normalizeRequest()
    {
        $_SERVER['REQUEST_URI'] = mb_strtolower($_SERVER['REQUEST_URI']);

        parent::normalizeRequest();

        if (!isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        //$route = Yii::app()->getUrlManager()->parseUrl($this);
        $route = $this->getPathInfo();

        if ($this->enableCsrfValidation) {
            foreach ($this->noCsrfValidationUris as $cr) {
                if (preg_match('#' . $cr . '#', $route)) {
                    Yii::app()->detachEventHandler('onBeginRequest', [$this, 'validateCsrfToken']);
                    Yii::trace('Route "' . $route . ' passed without CSRF validation');
                    break; // found first route and break
                }
            }
        }
    }
}
