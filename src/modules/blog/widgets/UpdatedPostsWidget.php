<?php

declare(strict_types=1);

namespace app\modules\blog\widgets;

use app\modules\blog\models\Post;
use yii\base\Widget;
use yii\caching\TagDependency;

final class UpdatedPostsWidget extends Widget
{
    public string $tpl = 'default';
    public string $class = '';
    public int $limit = 10;

    public function run(): string
    {
        $posts = Post::find()
            ->published()
            ->orderBy(['update_date' => SORT_DESC])
            ->cache(0, new TagDependency(['tags' => ['blog']]))
            ->limit($this->limit)
            ->all();

        return $this->render('UpdatedPosts/' . $this->tpl, [
            'posts' => $posts,
        ]);
    }
}
