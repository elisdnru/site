<?php

namespace app\modules\follow\widgets;

use CHtml;
use app\modules\main\components\widgets\DWidget;
use Yii;

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
