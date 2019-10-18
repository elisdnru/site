<?php

declare(strict_types=1);

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class ColorboxAsset extends AssetBundle
{
    public $baseUrl = '/build';

    public $css = [
        'colorbox.css',
    ];

    public $js = [
        'colorbox.js',
    ];

    public $depends = [
        JqueryAsset::class,
    ];
}
