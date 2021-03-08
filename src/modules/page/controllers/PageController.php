<?php

namespace app\modules\page\controllers;

use yii\web\Controller;
use app\modules\page\models\Page;
use yii\caching\TagDependency;
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
        /** @var Page|null $page */
        $page = Page::find()->cache(0, new TagDependency(['tags' => ['page']]))->findByPath($path);
        if ($page === null) {
            throw new NotFoundHttpException();
        }
        return $page;
    }
}
