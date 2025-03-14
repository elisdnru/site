<?php

declare(strict_types=1);

namespace tests\integration\components\category;

use Override;
use yii\base\InvalidArgumentException;
use yii\web\UrlRuleInterface;

final class CategoryUrlRule implements UrlRuleInterface
{
    #[Override]
    public function createUrl($manager, $route, $params): bool|string
    {
        if ($route !== 'category') {
            return false;
        }

        if (empty($params['category'])) {
            throw new InvalidArgumentException('Empty path.');
        }

        return (string)$params['category'];
    }

    #[Override]
    public function parseRequest($manager, $request): array|bool
    {
        if (!preg_match('|^(?P<category>\w[\w_/-]+)$|', $request->getPathInfo(), $matches)) {
            return false;
        }

        return ['category/show', $matches];
    }
}
