<?php

namespace app\modules\subscribe\controllers;

use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex(): string
    {
        return $this->render('index');
    }

    public function actionActivate(): string
    {
        return $this->render('activate');
    }

    public function actionSuccess(): string
    {
        return $this->render('success');
    }
}
