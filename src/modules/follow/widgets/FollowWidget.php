<?php

class FollowWidget extends DWidget
{
    public $tpl = 'Follow';

    public function run()
    {
        $assetsUrl = $this->registerScripts();
        $this->render($this->tpl, [
            'assetsUrl' => $assetsUrl,
        ]);
    }

    protected function registerScripts()
    {
        $url = CHtml::asset(Yii::getPathOfAlias('follow.assets'));
        Yii::app()->clientScript->registerCssFile($url . '/follow.css');
        return $url;
    }
}
