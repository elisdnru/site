<?php

declare(strict_types=1);

namespace app\assets;

use yii\web\AssetBundle;

class BlogPostAsset extends AssetBundle
{
    public $baseUrl = '/build';

    public $css = [
        'blog-post.css',
    ];

    public $depends = [
        MainAsset::class
    ];
}
