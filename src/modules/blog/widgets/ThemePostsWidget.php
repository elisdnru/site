<?php

namespace app\modules\blog\widgets;

use app\components\module\UrlRulesHelper;
use app\modules\blog\models\Group;
use app\components\widgets\Widget;

UrlRulesHelper::import('blog');

class ThemePostsWidget extends Widget
{
    public $tpl = 'ThemePosts';
    public $current = 0;
    public $group = 0;

    public function run()
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
