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

    public function actionUrl($a)
    {
        $this->redirect($a);
        Yii::app()->end();
    }
}
