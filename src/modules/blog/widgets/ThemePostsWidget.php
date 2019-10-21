<?php

namespace app\modules\blog\widgets;

use app\modules\blog\models\Group;
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

        $group = Group::model()->findByPk($this->group);

        return $this->render($this->tpl, [
            'group' => $group,
            'current' => $this->current,
        ]);
    }
}
