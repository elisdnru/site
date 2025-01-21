<?php

declare(strict_types=1);

namespace app\modules\page\controllers;

use yii\web\Controller;

/**
 * @psalm-api
 */
final class DefaultController extends Controller
{
    public function actionCopyright(): string
    {
        return $this->render('copyright');
    }

    public function actionPrivacy(): string
    {
        return $this->render('privacy');
    }
}
