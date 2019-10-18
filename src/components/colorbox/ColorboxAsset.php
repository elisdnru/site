<?php

declare(strict_types=1);

namespace app\components\colorbox;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class ColorboxAsset extends AssetBundle
{
    public $sourcePath = '@app/components/colorbox/assets';

    public $css = [
        'colorbox.css',
    ];

    public $js = [
        'jquery.colorbox-min.js',
        'colorbox.js',
    ];

    public $depends = [
        JqueryAsset::class,
    ];
}
