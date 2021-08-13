<?php

declare(strict_types=1);

namespace app\components;

use Throwable;
use yii\web\ErrorHandler;
use yii\web\HttpException;
use function Sentry\captureException;

final class SentryErrorHandler extends ErrorHandler
{
    public bool $sentryActive = false;

    public function logException($exception): void
    {
        parent::logException($exception);

        if ($this->sentryActive) {
            $this->reportException($exception);
        }
    }

    private function reportException(Throwable $exception): void
    {
        if ($exception instanceof HttpException && \in_array($exception->statusCode, [404, 403], true)) {
            return;
        }

        captureException($exception);
    }
}
