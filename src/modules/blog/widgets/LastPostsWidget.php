<?php

namespace app\modules\blog\widgets;

use app\components\module\UrlRulesHelper;
use app\modules\blog\models\Post;
use CDbCriteria;
use app\components\widgets\Widget;
use app\extensions\cachetagging\Tags;

UrlRulesHelper::import('blog');

class LastPostsWidget extends Widget
{
    public $tpl = 'default';
    public $class = '';
    public $limit = 10;

    public function run()
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
