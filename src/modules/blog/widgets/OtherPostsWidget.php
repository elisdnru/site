<?php

declare(strict_types=1);

namespace app\modules\blog\widgets;

use app\modules\blog\models\Post;
use Override;
use yii\base\Widget;

final class OtherPostsWidget extends Widget
{
    public int $current = 0;

    #[Override]
    public function run(): string
    {
        $promoted = Post::find()
            ->published()
            ->select('id')
            ->andWhere(['!=', 'id', $this->current])
            ->andWhere(['promoted' => true])
            ->column();

        $prev = Post::find()
            ->published()
            ->select('id')
            ->andWhere(['<', 'id', $this->current])
            ->andWhere(['not in', 'id', $promoted])
            ->orderBy(['id' => SORT_DESC])
            ->limit(1)
            ->column();

        $next = array_reverse(Post::find()
            ->published()
            ->select('id')
            ->andWhere(['>', 'id', $this->current])
            ->andWhere(['not in', 'id', $promoted])
            ->orderBy(['id' => SORT_ASC])
            ->limit(1)
            ->column());

        $posts = Post::find()
            ->orderBy(['id' => SORT_DESC])
            ->andWhere(['id' => array_merge($prev, $promoted, $next)])
            ->all();

        return $this->render('OtherPosts', [
            'posts' => $posts,
        ]);
    }
}
