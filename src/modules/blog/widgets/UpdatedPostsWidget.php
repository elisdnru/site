<?php

namespace app\modules\blog\widgets;

use app\components\module\DUrlRulesHelper;
use app\modules\blog\models\BlogPost;
use CDbCriteria;
use app\modules\main\components\widgets\DWidget;
use app\extensions\cachetagging\Tags;

DUrlRulesHelper::import('blog');

class UpdatedPostsWidget extends DWidget
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

        $posts = BlogPost::model()->cache(0, new Tags('blog'))->findAll($criteria);

        $this->render('UpdatedPosts/' . $this->tpl, [
            'posts' => $posts,
        ]);
    }
}
