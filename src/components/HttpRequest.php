<?php

/*
 * http://creative-territory.net/post/view/id/25/
 */

namespace app\components;

use CHttpRequest;
use Yii;

class HttpRequest extends CHttpRequest
{
    public $noCsrfValidationUris = [];

    protected function normalizeRequest(): void
    {
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
