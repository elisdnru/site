<?php

namespace app\widgets;

use Yii;
use yii\base\Widget;

class ShareWidget extends Widget
{
    public $url = '';
    public $title = '';
    public $description = '';
    public $image = '';

    public function run(): string
    {
        $host = Yii::$app->request->getHostInfo();

        return $this->render('Share', [
            'url' => $this->url ?: $host . '/' . Yii::$app->request->getPathInfo(),
            'title' => $this->title,
            'description' => mb_substr(strip_tags($this->description), 0, 200, 'UTF-8') . '...',
            'image' => $this->image ? $host . $this->image : '',
        ]);
    }
}
