<?php

namespace app\modules\products\controllers;

use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex(): string
    {
        return $this->render('index');
    }
}
