<?php

declare(strict_types=1);

namespace app\assets;

use yii\web\AssetBundle;

class AdminBarAsset extends AssetBundle
{
    public $baseUrl = '/build';

    public $css = [
        'admin-bar.css',
    ];

    public $depends = [
        MainAsset::class
    ];
}
