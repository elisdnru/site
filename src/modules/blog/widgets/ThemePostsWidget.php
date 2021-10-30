<?php

declare(strict_types=1);

namespace app\modules\blog\widgets;

use app\modules\blog\models\Post;
use yii\base\Widget;

final class ThemePostsWidget extends Widget
{
    public int $current = 0;
    public ?int $group = null;

    public function run(): string
    {
        if ($this->group === null || $this->group === 0) {
            return '';
        }

        $posts = Post::find()
            ->published()
            ->andWhere(['group_id' => $this->group])
            ->orderBy(['date' => SORT_ASC])
            ->all();

        return $this->render('ThemePosts', [
            'posts' => $posts,
            'current' => $this->current,
        ]);
    }
}
