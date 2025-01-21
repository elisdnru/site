<?php

declare(strict_types=1);

namespace app\components;

use yii\base\Behavior;
use yii\base\ViewEvent;
use yii\web\View;

final class ContentReplaceBehavior extends Behavior
{
    public array $replaces = [];

    public function events(): array
    {
        return [
            View::EVENT_AFTER_RENDER => $this->afterRender(...),
        ];
    }

    private function afterRender(ViewEvent $event): void
    {
        $event->output = strtr($event->output, $this->replaces);
    }
}
