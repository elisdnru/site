<?php

Yii::import('application.modules.blog.models.*');
DUrlRulesHelper::import('blog');

class AdsenseWidget extends DWidget
{
    public $tpl = 'default';

    public function run()
    {
        $this->render($this->tpl);
    }
}
