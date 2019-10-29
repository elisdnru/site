<?php

namespace app\modules\landing\components\v1;

use CBaseUrlRule;
use app\modules\landing\models\Landing;
use Yii;

class LandingUrlRule extends CBaseUrlRule
{
    public $connectionID = 'db';
    public $cache = 0;

    public function createUrl($manager, $route, $params, $ampersand)
    {
        if ($route === 'landing/landing/show') {
            if (isset($params['path'])) {
                return $params['path'];
            }
        }
        return false;
    }

    public function parseUrl($manager, $request, $pathInfo, $rawPathInfo)
    {
        if (preg_match('|^(?P<path>\w[\w_/-]+)$|', $pathInfo, $matches)) {
            if (Yii::app()->hasModule($matches['path'])) {
                return false;
            }

            if (Landing::model()->cache($this->cache)->findByPath($matches['path'])) {
                $_GET['path'] = $matches['path'];

                if (isset($matches['landing'])) {
                    $_GET['landing'] = $matches['landing'];
                }

                return 'landing/landing/show';
            }
        }
        return false;
    }
}
