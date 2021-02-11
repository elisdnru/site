<?php

namespace app\modules\landing\controllers;

use yii\web\Controller;

class DefaultController extends Controller
{
    public $layout = 'main';

    public function actionOopWeek(): string
    {
        return $this->render('oop-week');
    }

    public function actionGitComposer(): string
    {
        return $this->render('git-composer');
    }
}
