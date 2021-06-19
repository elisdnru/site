<?php

declare(strict_types=1);

namespace app\assets;

use yii\web\AssetBundle;

class PortfolioAsset extends AssetBundle
{
    public $baseUrl = '/build';

    public $css = [
        'portfolio.css',
    ];

    public $depends = [
        MainAsset::class,
    ];
}
