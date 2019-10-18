<?php

namespace app\modules\blog\widgets;

use app\modules\blog\models\Post;
use CDbCriteria;
use app\extensions\cachetagging\Tags;
use CWidget;

class LastPostsWidget extends CWidget
{
    public $tpl = 'default';
    public $class = '';
    public $limit = 10;

    public function run(): void
    {
        $criteria = new CDbCriteria;
        $criteria->scopes = ['published'];
        $criteria->limit = $this->limit;
        $criteria->order = 'date DESC';
        $criteria->with = ['category', 'tags'];

        $posts = Post::model()->cache(0, new Tags('blog'))->findAll($criteria);

        $this->render('LastPosts/' . $this->tpl, [
            'posts' => $posts,
        ]);
    }
}
