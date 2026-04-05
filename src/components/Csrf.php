<?php

declare(strict_types=1);

namespace app\components;

use BadMethodCallException;
use Webmozart\Assert\Assert;
use Yii;
use yii\helpers\Html;
use yii\web\Application;
use yii\web\Request;

final class Csrf
{
    public static function hiddenInput(): string
    {
        $request = Assert::isInstanceOf(Yii::$app, Application::class)->request;

        if (!$request instanceof Request) {
            throw new BadMethodCallException('Unable to use non-web request.');
        }

        return Html::hiddenInput($request->csrfParam, $request->getCsrfToken());
    }
}
