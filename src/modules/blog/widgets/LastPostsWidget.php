<?php

namespace app\modules\blog\widgets;

use app\modules\blog\models\Post;
use app\extensions\cachetagging\Tags;
use yii\base\Widget;

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
            ->cache(0, new Tags('blog'))
            ->all();

        return $this->render('LastPosts/' . $this->tpl, [
            'posts' => $posts,
        ]);
    }
}
