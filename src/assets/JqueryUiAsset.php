<?php

declare(strict_types=1);

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class JqueryUiAsset extends AssetBundle
{
    public $baseUrl = '/build';

    public $css = [
        'jquery-ui.css',
    ];

    public $js = [
        'jquery-ui.js',
    ];

    public $depends = [
        JqueryAsset::class,
    ];
}
