<?php

namespace app\modules\blog\widgets;

use app\modules\blog\models\Post;
use CDbCriteria;
use app\extensions\cachetagging\Tags;
use yii\base\Widget;

class UpdatedPostsWidget extends Widget
{
    public $tpl = 'default';
    public $class = '';
    public $limit = 10;

    public function run(): string
    {
        $posts = Post::find()
            ->published()
            ->orderBy(['update_date' => SORT_DESC])
            ->cache(0, new Tags('blog'))
            ->limit($this->limit)
            ->all();

        return $this->render('UpdatedPosts/' . $this->tpl, [
            'posts' => $posts,
        ]);
    }
}
