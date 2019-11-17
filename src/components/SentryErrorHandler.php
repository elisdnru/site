<?php

declare(strict_types=1);

namespace app\components;

use yii\web\ErrorHandler;
use yii\web\HttpException;
use function Sentry\captureException;

class SentryErrorHandler extends ErrorHandler
{
    public $sentryActive = false;

    public function logException($exception): void
    {
        parent::logException($exception);

        if ($this->sentryActive) {
            $this->reportException($exception);
        }
    }

    public function reportException($exception): void
    {
        if ($exception instanceof HttpException && in_array($exception->statusCode, [404, 403], true)) {
            return;
        }

        captureException($exception);
    }
}
