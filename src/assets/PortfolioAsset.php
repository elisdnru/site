<?php

declare(strict_types=1);

namespace app\assets;

use yii\web\AssetBundle;

final class PortfolioAsset extends AssetBundle
{
    public $baseUrl = '/build';

    public $css = [
        'portfolio.css',
    ];

    public $depends = [
        MainAsset::class,
    ];
}
