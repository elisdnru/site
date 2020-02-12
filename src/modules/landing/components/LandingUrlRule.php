<?php

namespace app\modules\landing\components;

use app\modules\landing\models\Landing;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\UrlRuleInterface;

class LandingUrlRule implements UrlRuleInterface
{
    public $cache = 0;

    public function createUrl($manager, $route, $params)
    {
        if ($route !== 'landing/landing/show') {
            return false;
        }

        if (empty($params['path'])) {
            throw new InvalidArgumentException('Empty landing path.');
        }

        return $params['path'];
    }

    /**
     * @inheritDoc
     */
    public function parseRequest($manager, $request)
    {
        if (!preg_match('|^(?P<path>\w[\w_/-]+)$|', $request->getPathInfo(), $matches)) {
            return false;
        }

        if (Yii::$app->hasModule($matches['path'])) {
            return false;
        }

        if (!Landing::find()->cache($this->cache)->findByPath($matches['path'])) {
            return false;
        }

        return ['landing/landing/show', $matches];
    }
}
