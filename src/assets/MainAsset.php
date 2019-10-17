<?php

declare(strict_types=1);

namespace app\assets;

use yii\web\AssetBundle;

class MainAsset extends AssetBundle
{
    public $baseUrl = '/build';

    public $css = [
        'main.css',
    ];

    public $js = [
        'main.js',
    ];
}
