<?php

namespace app\modules\blog\widgets;

use app\modules\blog\models\Post;
use yii\base\Widget;

class ThemePostsWidget extends Widget
{
    public string $tpl = 'ThemePosts';
    public int $current = 0;
    public ?int $group = null;

    public function run(): string
    {
        if ($this->group === null) {
            return '';
        }

        $posts = Post::findAll(['group_id' => $this->group]);

        return $this->render($this->tpl, [
            'posts' => $posts,
            'current' => $this->current,
        ]);
    }
}
