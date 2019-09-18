<?php

namespace app\modules\main\controllers;

use app\modules\main\components\Controller;
use app\modules\page\models\Page;
use app\extensions\cachetagging\Tags;
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
