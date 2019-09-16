<?php

namespace app\modules\main\controllers;

use app\modules\main\components\DController;
use app\modules\page\models\Page;
use app\extensions\cachetagging\Tags;
use Yii;

class DefaultController extends DController
{
    public function actionIndex()
    {
        $this->render('index', [
            'page' => $this->loadIndexPage(),
        ]);
    }

    public function actionUrl($a)
    {
        $this->redirect($a);
        Yii::app()->end();
    }

    public function actionConfigjs()
    {
        header('Content-Type: application/x-javascript');
        echo $this->renderPartial('config', null, true);
        Yii::app()->end();
    }

    protected function loadIndexPage()
    {
        if (!$page = Page::model()->cache(0, new Tags('page'))->findByPath('index')) {
            $page = new Page;
            $page->title = 'Главная';
            $page->pagetitle = $page->title;
        }
        return $page;
    }
}
