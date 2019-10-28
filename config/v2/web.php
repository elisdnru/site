<?php

use yii\helpers\ArrayHelper;

return ArrayHelper::merge(
    require(__DIR__ . '/common.php'),
    [
        'components' => [
            'request' => [
                'cookieValidationKey' => getenv('COOKIE_SECRET'),
            ],
        ],
    ]
);
