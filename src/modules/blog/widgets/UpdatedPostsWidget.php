<?php

Yii::import('application.modules.blog.models.*');
DUrlRulesHelper::import('blog');

class UpdatedPostsWidget extends DWidget
{
    public $tpl = 'default';
	public $class = '';
	public $limit = 10;

	public function run()
	{
        $criteria = new CDbCriteria;
        $criteria->scopes = array('published');
        $criteria->limit = $this->limit;
        $criteria->order = 'update_date DESC';
        $criteria->with = array('category');

        $posts = BlogPost::model()->cache(0, new Tags('blog'))->findAll($criteria);

		$this->render('UpdatedPosts/' . $this->tpl ,array(
            'posts'=>$posts,
        ));
	}

}