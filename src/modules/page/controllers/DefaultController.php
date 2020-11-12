<?php

namespace app\modules\page\controllers;

use yii\web\Controller;

class DefaultController extends Controller
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
