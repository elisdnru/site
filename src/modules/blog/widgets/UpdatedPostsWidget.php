<?php

namespace app\modules\blog\widgets;

use app\modules\blog\models\Post;
use CDbCriteria;
use app\components\widgets\Widget;
use app\extensions\cachetagging\Tags;

class UpdatedPostsWidget extends Widget
{
    public $tpl = 'default';
    public $class = '';
    public $limit = 10;

    public function run()
    {
        $criteria = new CDbCriteria;
        $criteria->scopes = ['published'];
        $criteria->limit = $this->limit;
        $criteria->order = 'update_date DESC';
        $criteria->with = ['category'];

        $posts = Post::model()->cache(0, new Tags('blog'))->findAll($criteria);

        $this->render('UpdatedPosts/' . $this->tpl, [
            'posts' => $posts,
        ]);
    }
}
