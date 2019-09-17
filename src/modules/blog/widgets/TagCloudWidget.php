<?php

namespace app\modules\blog\widgets;

use app\components\module\UrlRulesHelper;
use app\modules\blog\models\BlogTag;
use app\modules\main\components\widgets\Widget;
use app\extensions\cachetagging\Tags;

UrlRulesHelper::import('blog');

class TagCloudWidget extends Widget
{
    public $tpl = 'TagCloud';
    public $tags = '';

    public function run()
    {
        $tags = BlogTag::model()->with('frequency')->cache(0, new Tags('blog'))->findAll(['order' => 'title ASC']);
        $this->render($this->tpl, ['tags' => $tags]);
    }
}
