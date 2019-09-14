<?php

namespace app\modules\page\widgets;

use app\components\module\DUrlRulesHelper;
use DWidget;
use app\modules\page\models\Page;
use Tags;

DUrlRulesHelper::import('page');

class PageWidget extends DWidget
{
    public $alias;

    public function run()
    {
        $page = Page::model()->cache(0, new Tags('page'))->findByPath($this->alias);
        $this->render('Page', ['page' => $page]);
    }
}
