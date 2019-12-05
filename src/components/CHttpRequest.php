<?php

declare(strict_types=1);

namespace app\components;

use CHttpRequest as Base;
use Yii;

class CHttpRequest extends Base
{
    protected function normalizeRequest(): void
    {
        if ($this->enableCsrfValidation) {
            Yii::app()->attachEventHandler('onBeginRequest', [$this, 'validateCsrfToken']);
        }
    }
}
