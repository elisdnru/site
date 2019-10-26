<?php

namespace app\modules\page\components\v2;

use app\modules\page\models\Page;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\UrlRuleInterface;

class PageUrlRule implements UrlRuleInterface
{
    public $cache = 0;

    public function createUrl($manager, $route, $params)
    {
        if ($route !== 'page/page/show') {
            return false;
        }

        if (empty($params['path'])) {
            throw new InvalidArgumentException('Empty page path.');
        }

        return $params['path'];
    }

    public function parseRequest($manager, $request)
    {
        if (!preg_match('|^(?P<path>\w[\w_/-]+)$|', $request->getPathInfo(), $matches)) {
            return false;
        }

        if (Yii::$app->hasModule($matches['path'])) {
            return false;
        }

        if (!Page::model()->cache($this->cache)->findByPath($matches['path'])) {
            return false;
        }

        $_GET['path'] = $matches['path'];

        if (isset($matches['page'])) {
            $_GET['page'] = $matches['page'];
        }

        return 'page/page/show';
    }
}
