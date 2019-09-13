<?php

use app\components\module\DUrlRulesHelper;

DUrlRulesHelper::import('blog');

class TagCloudWidget extends DWidget
{
    public $tpl = 'TagCloud';
    public $tags = '';

    public function run()
    {
        $tags = BlogTag::model()->with('frequency')->cache(0, new Tags('blog'))->findAll(['order' => 'title ASC']);
        $this->render($this->tpl, ['tags' => $tags]);
    }
}
