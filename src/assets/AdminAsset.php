<?php

declare(strict_types=1);

namespace app\assets;

use yii\web\AssetBundle;

class AdminAsset extends AssetBundle
{
    public $baseUrl = '/build';

    public $css = [
        'admin.css',
    ];

    public $depends = [
        MainAsset::class
    ];
}
