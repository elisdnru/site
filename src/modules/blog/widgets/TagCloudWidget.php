<?php

namespace app\modules\blog\widgets;

use app\modules\blog\models\Tag;
use app\extensions\cachetagging\Tags;
use yii\base\Widget;

class TagCloudWidget extends Widget
{
    public $tpl = 'TagCloud';
    public $tags = '';

    public function run(): string
    {
        $tags = Tag::model()->with('frequency')->cache(0, new Tags('blog'))->findAll(['order' => 'title ASC']);
        return $this->render($this->tpl, ['tags' => $tags]);
    }
}
