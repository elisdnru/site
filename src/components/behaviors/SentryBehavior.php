<?php

declare(strict_types=1);

namespace app\components\behaviors;

use CBehavior;
use CExceptionEvent;
use function Sentry\captureException;

class SentryBehavior extends CBehavior
{
    public function events(): array
    {
        return [
            'onException' => 'onException',
        ];
    }

    public function onException(CExceptionEvent $event): void
    {
        captureException($event->exception);
    }
}
