<?php

declare(strict_types=1);

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class ETimerAsset extends AssetBundle
{
    public $baseUrl = 'https://e-timer.ru';

    public $js = [
        'js/etimer.js',
    ];

    public $depends = [
        JqueryAsset::class,
    ];
}
