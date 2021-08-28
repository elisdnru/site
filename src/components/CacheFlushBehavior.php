<?php

declare(strict_types=1);

namespace app\components;

use yii\base\ActionEvent;
use yii\base\Behavior;
use yii\caching\CacheInterface;
use yii\caching\TagDependency;
use yii\web\Controller;

final class CacheFlushBehavior extends Behavior
{
    private CacheInterface $cache;

    public function __construct(CacheInterface $cache, array $config = [])
    {
        parent::__construct($config);
        $this->cache = $cache;
    }

    public function events(): array
    {
        return [Controller::EVENT_BEFORE_ACTION => 'beforeAction'];
    }

    public function beforeAction(ActionEvent $event): void
    {
        $tag = $event->action->controller->module->id;
        TagDependency::invalidate($this->cache, $tag);
    }
}
