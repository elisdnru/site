<?php

declare(strict_types=1);

namespace app\modules\blog\widgets;

use app\modules\blog\models\Post;
use yii\base\Widget;

final class OtherPostsWidget extends Widget
{
    public int $current = 0;

    public function run(): string
    {
        $prev = Post::find()->published()
            ->andWhere(['<', 'id', $this->current])
            ->orderBy(['id' => SORT_DESC])
            ->limit(2)
            ->all();

        $next = array_reverse(Post::find()->published()
            ->andWhere(['>', 'id', $this->current])
            ->orderBy(['id' => SORT_ASC])
            ->limit(2)
            ->all());

        $posts = array_merge($next, $prev);

        return $this->render('OtherPosts', [
            'posts' => $posts,
        ]);
    }
}
