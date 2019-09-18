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
        $this->render('index', [
            'page' => $this->loadIndexPage(),
        ]);
    }

    public function actionUrl($a)
    {
        $this->redirect($a);
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
