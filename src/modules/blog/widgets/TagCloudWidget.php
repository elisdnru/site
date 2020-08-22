<?php

namespace app\modules\blog\widgets;

use app\modules\blog\models\Tag;
use yii\base\Widget;
use yii\caching\TagDependency;

class TagCloudWidget extends Widget
{
    public string $tpl = 'TagCloud';

    public function run(): string
    {
        $tags = Tag::find()->cache(0, new TagDependency(['tags' => ['blog']]))->orderBy(['title' => SORT_ASC])->all();
        return $this->render($this->tpl, ['tags' => $tags]);
    }
}
