<?php

namespace app\modules\main\controllers;

use app\components\Controller;
use Yii;

class DefaultController extends Controller
{
    public function actionIndex(): void
    {
        $this->render('index');
    }
}
