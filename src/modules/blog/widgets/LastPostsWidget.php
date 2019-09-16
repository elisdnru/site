<?php

namespace app\modules\blog\widgets;

use app\components\module\DUrlRulesHelper;
use app\modules\blog\models\BlogPost;
use CDbCriteria;
use app\modules\main\components\widgets\DWidget;
use app\extensions\cachetagging\Tags;

DUrlRulesHelper::import('blog');

class LastPostsWidget extends DWidget
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

        $posts = BlogPost::model()->cache(0, new Tags('blog'))->findAll($criteria);

        $this->render('LastPosts/' . $this->tpl, [
            'posts' => $posts,
        ]);
    }
}
