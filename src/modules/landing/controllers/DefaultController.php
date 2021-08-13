<?php

declare(strict_types=1);

namespace app\modules\landing\controllers;

use yii\web\Controller;

final class DefaultController extends Controller
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

    public function actionYii2Shop(): string
    {
        return $this->render('yii2-shop');
    }

    public function actionLaravelBoard(): string
    {
        return $this->render('laravel-board');
    }

    public function actionProjectManager(): string
    {
        return $this->render('project-manager');
    }
}
