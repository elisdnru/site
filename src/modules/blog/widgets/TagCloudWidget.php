<?php

namespace app\modules\blog\widgets;

use app\modules\blog\models\Tag;
use app\extensions\cachetagging\Tags;
use CWidget;

class TagCloudWidget extends CWidget
{
    public $tpl = 'TagCloud';
    public $tags = '';

    public function run(): void
    {
        $tags = Tag::model()->with('frequency')->cache(0, new Tags('blog'))->findAll(['order' => 'title ASC']);
        $this->render($this->tpl, ['tags' => $tags]);
    }
}
