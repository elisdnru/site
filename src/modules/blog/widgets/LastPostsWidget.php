<?php

namespace app\modules\blog\widgets;

use app\modules\blog\models\Post;
use yii\base\Widget;
use yii\caching\TagDependency;

class LastPostsWidget extends Widget
{
    public $tpl = 'default';
    public $class = '';
    public $limit = 10;

    public function run(): string
    {
        $posts = Post::find()
            ->published()
            ->limit($this->limit)
            ->orderBy(['date' => SORT_DESC])
            ->with(['category', 'tags'])
            ->cache(0, new TagDependency(['tags' => ['blog']]))
            ->all();

        return $this->render('LastPosts/' . $this->tpl, [
            'posts' => $posts,
        ]);
    }
}
