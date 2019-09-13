<?php

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
