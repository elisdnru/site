<?php

declare(strict_types=1);

namespace app\modules\blog\widgets;

use app\modules\blog\models\Post;
use yii\base\Widget;

final class OtherPostsWidget extends Widget
{
    public int $skip = 0;
    public int $limit = 5;

    public function run(): string
    {
        $query = Post::find()->published()->limit($this->limit);

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

        return $this->render('OtherPosts', [
            'posts' => $posts,
        ]);
    }
}
