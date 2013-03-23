<?php

Yii::import('blog.models.BlogPost');
DUrlRulesHelper::import('blog');

class LastPostsWidget extends DWidget
{
    public $tpl = 'default';
	public $class = '';
	public $limit = 10;

	public function run()
	{
        $criteria = new CDbCriteria;
        $criteria->scopes = array('published');
        $criteria->limit = $this->limit;
        $criteria->order = 'date DESC';
        $criteria->with = array('category', 'tags');

        $posts = BlogPost::model()->cache(30)->findAll($criteria);

		$this->render('LastPosts/' . $this->tpl ,array(
            'posts'=>$posts,
        ));
	}

}