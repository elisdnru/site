<?php

namespace app\modules\page\controllers;

use CHttpException;
use app\components\Controller;
use app\modules\page\models\Page;
use app\extensions\cachetagging\Tags;

class PageController extends Controller
{
    public function actionShow($path = 'index'): string
    {
        $page = $this->loadModel($path);

        $this->layout = $page->layout;
        $subpages_layout = 'subpages/' . $page->subpages_layout;

        return $this->render('show', [
            'page' => $page,
            'subpages_layout' => $subpages_layout,
        ]);
    }

    protected function loadModel($path): Page
    {
        $page = Page::model()->cache(0, new Tags('page'))->findByPath($path);
        if ($page === null) {
            throw new CHttpException('404', 'Страница не найдена');
        }
        return $page;
    }
}
