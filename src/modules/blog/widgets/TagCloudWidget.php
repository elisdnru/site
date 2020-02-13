<?php

namespace app\modules\blog\widgets;

use app\modules\blog\models\Tag;
use app\extensions\cachetagging\Tags;
use yii\base\Widget;

class TagCloudWidget extends Widget
{
    public $tpl = 'TagCloud';

    public function run(): string
    {
        $tags = Tag::find()->cache(0, new Tags('blog'))->orderBy(['title' => SORT_ASC])->all();
        return $this->render($this->tpl, ['tags' => $tags]);
    }
}
