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
        $this->initFields();

        $this->render('Share/' . $this->tpl, [
            'url' => $this->url,
            'title' => $this->title,
            'description' => mb_substr(strip_tags($this->description), 0, 200, 'UTF-8') . '...',
            'image' => $this->image,
        ]);
    }

    protected function initFields(): void
    {
        if (!trim($this->url)) {
            $this->url = Yii::app()->request->getHostInfo() . '/' . Yii::app()->request->getPathInfo();
        }
        if (!trim($this->title)) {
            $this->title = Yii::app()->controller->pageTitle;
        }
        if (!trim($this->description)) {
            $this->description = Yii::app()->controller->description;
        }
        if (trim($this->image)) {
            $this->image = Yii::app()->request->getHostInfo() . $this->image;
        }
    }
}
