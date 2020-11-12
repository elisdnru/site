<?php

namespace app\modules\contacts\controllers;

use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex(): string
    {
        return $this->render('index');
    }
}
