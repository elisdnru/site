<?php

declare(strict_types=1);

namespace app\assets;

use yii\web\AssetBundle;

final class BootstrapAsset extends AssetBundle
{
    public $baseUrl = '/build';

    public $css = [
        'bootstrap.css',
    ];
}
