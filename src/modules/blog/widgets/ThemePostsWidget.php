<?php

namespace app\modules\blog\widgets;

use app\modules\blog\models\Post;
use yii\base\Widget;

class ThemePostsWidget extends Widget
{
    public $tpl = 'ThemePosts';
    public $current = 0;
    public $group = 0;

    public function run(): string
    {
        if (!(int)$this->group) {
            return '';
        }

        $posts = Post::model()->findAllByAttributes(['group_id' => $this->group]);

        return $this->render($this->tpl, [
            'posts' => $posts,
            'current' => $this->current,
        ]);
    }
}
