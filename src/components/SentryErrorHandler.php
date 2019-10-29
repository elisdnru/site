<?php

declare(strict_types=1);

namespace app\components;

use CHttpException;
use yii\web\ErrorHandler;
use function Sentry\captureException;

class SentryErrorHandler extends ErrorHandler
{
    public $sentryActive = false;

    public function logException($exception): void
    {
        parent::logException($exception);

        if ((bool)getenv('APP_DEBUG')) {
            $this->reportException($exception);
        }
    }

    public function reportException($exception): void
    {
        if (!$this->sentryActive) {
            return;
        }

        if ($exception instanceof CHttpException && in_array($exception->getCode(), [404, 403], true)) {
            return;
        }

        captureException($exception);
    }
}
