<?php

namespace app\modules\blog\widgets;

use app\components\module\DUrlRulesHelper;
use BlogCategory;
use BlogPost;
use CDbCriteria;
use DWidget;

DUrlRulesHelper::import('blog');

class OtherPostsWidget extends DWidget
{
    public $tpl = 'OtherPosts';
    public $title = '';
    public $class = '';
    public $label = '';
    public $category = '';
    public $skip = 0;
    public $limit = 5;

    public function run()
    {
        $criteria = new CDbCriteria;
        $criteria->scopes = ['published'];
        $criteria->limit = $this->limit;

        if ($this->category) {
            $category = BlogCategory::model()->findByPk(trim($this->category));

            if (!$category) {
                return false;
            }

            $criteria->addCondition('category_id=:cat');
            $criteria->params[':cat'] = $category->id;
        } else {
            $category = new BlogCategory;
        }

        if ($this->skip) {
            $criteria->params[':skip'] = $this->skip;

            $prevCriteria = clone $criteria;
            $prevCriteria->addCondition('id < :skip');
            $prevCriteria->order = 'id DESC';

            $nextCriteria = clone $criteria;
            $nextCriteria->addCondition('id > :skip');
            $nextCriteria->order = 'id ASC';

            $posts = array_merge(
                array_reverse(BlogPost::model()->findAll($nextCriteria)),
                BlogPost::model()->findAll($prevCriteria)
            );
        } else {
            $posts = BlogPost::model()->findAll($criteria);
        }


        $this->render($this->tpl, [
            'posts' => $posts,
            'title' => $this->title,
            'label' => $this->label,
            'class' => $this->class,
            'category' => $category,
        ]);
    }
}
