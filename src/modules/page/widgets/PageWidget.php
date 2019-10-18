<?php

namespace app\modules\page\widgets;

use app\modules\page\models\Page;
use app\extensions\cachetagging\Tags;
use CWidget;

class PageWidget extends CWidget
{
    public $alias;

    public function run(): void
    {
        $page = Page::model()->cache(0, new Tags('page'))->findByPath($this->alias);
        $this->render('Page', ['page' => $page]);
    }
}
