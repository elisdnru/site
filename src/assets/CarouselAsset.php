<?php

declare(strict_types=1);

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class CarouselAsset extends AssetBundle
{
    public $baseUrl = '/build';

    public $js = [
        'jcarousellite.js',
    ];

    public $depends = [
        JqueryAsset::class,
    ];
}
