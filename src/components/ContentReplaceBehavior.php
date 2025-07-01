<?php

declare(strict_types=1);

namespace app\components;

use Override;
use yii\base\Behavior;
use yii\base\ViewEvent;
use yii\web\View;

/**
 * @extends Behavior<View>
 */
final class ContentReplaceBehavior extends Behavior
{
    public array $replaces = [];

    #[Override]
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
