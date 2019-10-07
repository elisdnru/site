<?php

namespace app\modules\page\widgets;

use app\components\widgets\Widget;
use app\modules\page\models\Page;
use app\extensions\cachetagging\Tags;

class PageWidget extends Widget
{
    public $alias;

    public function run()
    {
        $page = Page::model()->cache(0, new Tags('page'))->findByPath($this->alias);
        $this->render('Page', ['page' => $page]);
    }
}
