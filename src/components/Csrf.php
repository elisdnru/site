<?php

declare(strict_types=1);

namespace app\components;

use Yii;
use yii\helpers\Html;

class Csrf
{
    public static function hiddenInput(): string
    {
        return Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken());
    }
}
