<?php

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
