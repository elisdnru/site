<?php

use yii\helpers\ArrayHelper;
use yii\web\Request;

return ArrayHelper::merge(
    require(__DIR__ . '/web.php'),
    [
        'container' => [
            'singletons' => [
                Request::class => [
                    'cookieValidationKey' => 'test',
                ],
            ],
        ],
    ]
);
