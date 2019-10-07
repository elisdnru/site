<?php

namespace app\modules\blog\widgets;

use app\modules\blog\models\Tag;
use app\components\widgets\Widget;
use app\extensions\cachetagging\Tags;

class TagCloudWidget extends Widget
{
    public $tpl = 'TagCloud';
    public $tags = '';

    public function run()
    {
        $tags = Tag::model()->with('frequency')->cache(0, new Tags('blog'))->findAll(['order' => 'title ASC']);
        $this->render($this->tpl, ['tags' => $tags]);
    }
}
