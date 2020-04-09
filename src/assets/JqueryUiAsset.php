<?php

declare(strict_types=1);

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class JqueryUiAsset extends AssetBundle
{
    public $sourcePath = '@app/../assets/jui';

    public $css = [
        'css/jquery-ui.css',
    ];

    public $js = [
        'js/jquery-ui.min.js',
    ];

    public $depends = [
        JqueryAsset::class,
    ];
}
