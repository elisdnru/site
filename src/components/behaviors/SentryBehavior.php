<?php

declare(strict_types=1);

namespace app\components\behaviors;

use CBehavior;
use CExceptionEvent;
use CHttpException;
use function Sentry\captureException;

class SentryBehavior extends CBehavior
{
    private $active;

    public function __construct(bool $active)
    {
        $this->active = $active;
    }

    public function events(): array
    {
        return [
            'onException' => 'onException',
        ];
    }

    public function onException(CExceptionEvent $event): void
    {
        if (!$this->active) {
            return;
        }

        $exception = $event->exception;

        if ($exception instanceof CHttpException && in_array($exception->getCode(), [404, 403], true)) {
            return;
        }

        captureException($exception);
    }
}