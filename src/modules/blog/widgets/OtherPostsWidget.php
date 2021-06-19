<?php

declare(strict_types=1);

namespace app\modules\blog\widgets;

use app\modules\blog\models\Category;
use app\modules\blog\models\Post;
use yii\base\Widget;

class OtherPostsWidget extends Widget
{
    public string $tpl = 'OtherPosts';
    public string $title = '';
    public string $class = '';
    public string $label = '';
    public string $category = '';
    public int $skip = 0;
    public int $limit = 5;

    public function run(): string
    {
        $query = Post::find()->published()->limit($this->limit);

        if ($this->category) {
            $category = Category::findOne(trim($this->category));

            if (!$category) {
                return '';
            }
            $query->andWhere(['category_id' => $category->id]);
        } else {
            $category = new Category();
        }

        if ($this->skip) {
            $prevQuery = (clone $query)
                ->andWhere(['<', 'id', $this->skip])
                ->orderBy(['id' => SORT_DESC]);

            $nextQuery = (clone $query)
                ->andWhere(['>', 'id', $this->skip])
                ->orderBy(['id' => SORT_ASC]);

            $posts = array_merge(
                array_reverse($nextQuery->all()),
                $prevQuery->all()
            );
        } else {
            $posts = $query->all();
        }

        return $this->render($this->tpl, [
            'posts' => $posts,
            'title' => $this->title,
            'label' => $this->label,
            'class' => $this->class,
            'category' => $category,
        ]);
    }
}
