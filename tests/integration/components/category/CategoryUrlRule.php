<?php

declare(strict_types=1);

namespace tests\integration\components\category;

use yii\base\InvalidArgumentException;
use yii\web\UrlRuleInterface;

class CategoryUrlRule implements UrlRuleInterface
{
    public $cache = 0;

    public function createUrl($manager, $route, $params)
    {
        if ($route !== 'category') {
            return false;
        }

        if (empty($params['category'])) {
            throw new InvalidArgumentException('Empty path.');
        }

        return $params['category'];
    }

    /**
     * @inheritDoc
     */
    public function parseRequest($manager, $request)
    {
        if (!preg_match('|^(?P<category>\w[\w_/-]+)$|', $request->getPathInfo(), $matches)) {
            return false;
        }

        return ['category/show', $matches];
    }
}
