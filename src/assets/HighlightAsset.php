<?php

declare(strict_types=1);

namespace app\assets;

use yii\web\AssetBundle;

class HighlightAsset extends AssetBundle
{
    public $baseUrl = '/build';

    public $css = [
        'highlight.css',
    ];

    public $depends = [
        MainAsset::class,
    ];
}
