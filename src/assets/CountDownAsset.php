<?php

declare(strict_types=1);

namespace app\assets;

use yii\web\AssetBundle;

final class CountDownAsset extends AssetBundle
{
    public $baseUrl = '/build';

    public $js = [
        'countdown.js',
    ];

    public $depends = [
        ETimerAsset::class,
    ];
}
