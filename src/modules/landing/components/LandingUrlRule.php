<?php

declare(strict_types=1);

namespace app\modules\landing\components;

use app\modules\landing\models\Landing;
use yii\base\InvalidArgumentException;
use yii\web\UrlRuleInterface;

final class LandingUrlRule implements UrlRuleInterface
{
    public int $cache = 0;

    public function createUrl($manager, $route, $params): bool|string
    {
        if ($route !== 'landing/landing/show') {
            return false;
        }

        if (empty($params['path'])) {
            throw new InvalidArgumentException('Empty landing path.');
        }

        return (string)$params['path'];
    }

    /**
     * {@inheritDoc}
     */
    public function parseRequest($manager, $request): array|bool
    {
        if (!preg_match('|^(?P<path>\w[\w_/-]+)$|', $request->getPathInfo(), $matches)) {
            return false;
        }

        if (!Landing::find()->cache($this->cache)->findByPath($matches['path'])) {
            return false;
        }

        return ['landing/landing/show', $matches];
    }
}
