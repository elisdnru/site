<?php

DUrlRulesHelper::import('blog');

class ThemePostsWidget extends DWidget
{
    public $tpl = 'ThemePosts';
    public $current = 0;
    public $group = 0;

    public function run()
    {
        if (!(int)$this->group) {
            return;
        }

        $group = BlogPostGroup::model()->findByPk($this->group);

        $this->render($this->tpl, [
            'group' => $group,
            'current' => $this->current,
        ]);
    }
}
