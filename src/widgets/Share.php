<?php

declare(strict_types=1);

namespace app\widgets;

use BadMethodCallException;
use RuntimeException;
use Yii;
use yii\base\Widget;
use yii\web\Request;

class Share extends Widget
{
    public string $url = '';
    public string $title = '';
    public string $description = '';
    public string $image = '';

    public function run(): string
    {
        $request = Yii::$app->request;

        if (!$request instanceof Request) {
            throw new BadMethodCallException('Unable to use non-web request.');
        }

        $host = $request->getHostInfo();

        if ($host === null) {
            throw new RuntimeException('Empty host.');
        }

        return $this->render('Share', [
            'url' => $this->url ?: $host . '/' . $request->getPathInfo(),
            'title' => $this->title,
            'description' => mb_substr(strip_tags($this->description), 0, 200, 'UTF-8') . '...',
            'image' => $this->image ? $host . $this->image : '',
        ]);
    }
}
