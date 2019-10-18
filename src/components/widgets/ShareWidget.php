<?php

namespace app\components\widgets;

use CWidget;
use Yii;

class ShareWidget extends CWidget
{
    public $tpl = 'default';
    public $url = '';
    public $title = '';
    public $description = '';
    public $image = '';

    public function run(): void
    {
        $host = Yii::app()->request->getHostInfo();

        $this->render('Share/' . $this->tpl, [
            'url' => $this->url ?: $host . '/' . Yii::app()->request->getPathInfo(),
            'title' => $this->title,
            'description' => mb_substr(strip_tags($this->description), 0, 200, 'UTF-8') . '...',
            'image' => $this->image ? $host . $this->image : '',
        ]);
    }
}
