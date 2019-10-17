<?php

declare(strict_types=1);

namespace app\assets;

use yii\web\AssetBundle;

class CommentsAsset extends AssetBundle
{
    public $baseUrl = '/build';

    public $css = [
        'comments.css',
    ];

    public $js = [
        'comments.js',
    ];

    public $depends = [
        MainAsset::class
    ];
}
