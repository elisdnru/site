<?php

declare(strict_types=1);

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\View;

final class ProductsAsset extends AssetBundle
{
    public $baseUrl = '';

    public $js = [
        'click',
    ];

    public $jsOptions = [
        'position' => View::POS_HEAD,
        'async' => true,
    ];
}
