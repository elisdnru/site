<?php

declare(strict_types=1);

namespace app\components;

use BadMethodCallException;
use Yii;
use yii\helpers\Html;
use yii\web\Request;

class Csrf
{
    public static function hiddenInput(): string
    {
        $request = Yii::$app->request;

        if (!$request instanceof Request) {
            throw new BadMethodCallException('Unable to use non-web request.');
        }

        return Html::hiddenInput($request->csrfParam, $request->getCsrfToken());
    }
}
