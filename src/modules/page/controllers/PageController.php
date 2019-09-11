<?php

namespace app\modules\page\controllers;

use CHttpException;
use DController;
use Page;
use Tags;

class PageController extends DController
{
    public function actionShow($path = 'index')
    {
        $page = $this->loadModel($path);

        if ($page->layout) {
            $this->layout = '//layouts/page/' . $page->layout->alias;
        } else {
            $this->layout = '//layouts/page/default';
        }

        $layout_subpages = 'subpages/' . ($page->layout_subpages ? $page->layout_subpages->alias : 'default');

        $this->render('show', [
                'page' => $page,
                'layout_subpages' => $layout_subpages,
            ]);
    }

    protected function loadModel($path)
    {
        $page = Page::model()->cache(0, new Tags('page'))->findByPath($path);
        if ($page === null) {
            throw new CHttpException('404', 'Страница не найдена');
        }
        return $page;
    }
}
