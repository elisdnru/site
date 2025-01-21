<?php

declare(strict_types=1);

namespace app\modules\products\controllers;

use yii\web\Controller;

/**
 * @psalm-api
 */
final class DefaultController extends Controller
{
    public function actionIndex(): string
    {
        return $this->render('index');
    }
}
