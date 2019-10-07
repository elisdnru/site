<?php

namespace app\modules\main\controllers;

use app\components\Controller;
use Yii;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $this->render('index');
    }
}
