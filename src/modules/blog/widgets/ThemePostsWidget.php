<?php

namespace app\modules\blog\widgets;

use app\modules\blog\models\Group;
use CWidget;

class ThemePostsWidget extends CWidget
{
    public $tpl = 'ThemePosts';
    public $current = 0;
    public $group = 0;

    public function run(): void
    {
        if (!(int)$this->group) {
            return;
        }

        $group = Group::model()->findByPk($this->group);

        $this->render($this->tpl, [
            'group' => $group,
            'current' => $this->current,
        ]);
    }
}
