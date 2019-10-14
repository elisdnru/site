<?php

namespace app\modules\blog\widgets;

use app\modules\blog\models\Category;
use app\modules\blog\models\Post;
use CDbCriteria;
use app\components\widgets\Widget;

class OtherPostsWidget extends Widget
{
    public $tpl = 'OtherPosts';
    public $title = '';
    public $class = '';
    public $label = '';
    public $category = '';
    public $skip = 0;
    public $limit = 5;

    public function run(): void
    {
        $criteria = new CDbCriteria;
        $criteria->scopes = ['published'];
        $criteria->limit = $this->limit;

        if ($this->category) {
            $category = Category::model()->findByPk(trim($this->category));

            if (!$category) {
                return;
            }

            $criteria->addCondition('category_id=:cat');
            $criteria->params[':cat'] = $category->id;
        } else {
            $category = new Category;
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
                array_reverse(Post::model()->findAll($nextCriteria)),
                Post::model()->findAll($prevCriteria)
            );
        } else {
            $posts = Post::model()->findAll($criteria);
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
