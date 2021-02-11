<?php

namespace app\modules\page\components;

use app\modules\page\models\Page;
use yii\base\InvalidArgumentException;
use yii\web\UrlRuleInterface;

class PageUrlRule implements UrlRuleInterface
{
    public int $cache = 0;

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

    /**
     * @inheritDoc
     */
    public function parseRequest($manager, $request): array|bool
    {
        if (!preg_match('|^(?P<path>\w[\w_/-]+)$|', $request->getPathInfo(), $matches)) {
            return false;
        }

        if (!Page::find()->cache($this->cache)->findByPath($matches['path'])) {
            return false;
        }

        return ['page/page/show', $matches];
    }
}
