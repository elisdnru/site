<?php

declare(strict_types=1);

namespace app\modules\donate\controllers;

use yii\web\Controller;

final class DefaultController extends Controller
{
    public function actionIndex(): string
    {
        return $this->render('index');
    }
}
