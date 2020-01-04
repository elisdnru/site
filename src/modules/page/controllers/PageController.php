<?php

namespace app\modules\page\controllers;

use app\components\Controller;
use app\modules\page\models\Page;
use app\extensions\cachetagging\Tags;
use yii\web\NotFoundHttpException;

class PageController extends Controller
{
    public function actionShow(string $path = 'index'): string
    {
        $page = $this->loadModel($path);

        $this->layout = $page->layout;
        $subpages_layout = 'subpages/' . $page->subpages_layout;

        return $this->render('show', [
            'page' => $page,
            'subpages_layout' => $subpages_layout,
        ]);
    }

    private function loadModel(string $path): Page
    {
        /** @var Page $page */
        $page = Page::model()->cache(0, new Tags('page'))->findByPath($path);
        if ($page === null) {
            throw new NotFoundHttpException();
        }
        return $page;
    }
}
