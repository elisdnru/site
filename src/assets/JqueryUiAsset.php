<?php

declare(strict_types=1);

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class JqueryUiAsset extends AssetBundle
{
    public $sourcePath = '@vendor/yiisoft/yii/framework/web/js/source/jui';

    public $css = [
        'css/base/jquery-ui.css',
    ];

    public $js = [
        'js/jquery-ui.min.js',
    ];

    public $depends = [
        JqueryAsset::class,
    ];
}
