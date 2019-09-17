<?php

namespace app\modules\page\widgets;

use app\components\module\UrlRulesHelper;
use app\modules\main\components\widgets\Widget;
use app\modules\page\models\Page;
use app\extensions\cachetagging\Tags;

UrlRulesHelper::import('page');

class PageWidget extends Widget
{
    public $alias;

    public function run()
    {
        $page = Page::model()->cache(0, new Tags('page'))->findByPath($this->alias);
        $this->render('Page', ['page' => $page]);
    }
}
