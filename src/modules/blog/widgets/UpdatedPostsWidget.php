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
        $criteria = new CDbCriteria;
        $criteria->scopes = ['published'];
        $criteria->limit = $this->limit;
        $criteria->order = 'update_date DESC';
        $criteria->with = [];

        $posts = Post::model()->cache(0, new Tags('blog'))->findAll($criteria);

        return $this->render('UpdatedPosts/' . $this->tpl, [
            'posts' => $posts,
        ]);
    }
}
