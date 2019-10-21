<?php

namespace app\modules\page\widgets;

use app\modules\page\models\Page;
use app\extensions\cachetagging\Tags;
use yii\base\Widget;

class PageWidget extends Widget
{
    public $alias;

    public function run(): string
    {
        $page = Page::model()->cache(0, new Tags('page'))->findByPath($this->alias);
        return $this->render('Page', ['page' => $page]);
    }
}
