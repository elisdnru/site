<?php

declare(strict_types=1);

namespace app\widgets;

use RuntimeException;
use Yii;
use yii\base\Widget;

class Share extends Widget
{
    public string $url = '';
    public string $title = '';
    public string $description = '';
    public string $image = '';

    public function run(): string
    {
        $host = Yii::$app->request->getHostInfo();

        if ($host === null) {
            throw new RuntimeException('Empty host.');
        }

        return $this->render('Share', [
            'url' => $this->url ?: $host . '/' . Yii::$app->request->getPathInfo(),
            'title' => $this->title,
            'description' => mb_substr(strip_tags($this->description), 0, 200, 'UTF-8') . '...',
            'image' => $this->image ? $host . $this->image : '',
        ]);
    }
}
