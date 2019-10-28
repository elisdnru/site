<?php

use app\components\UserIdentity;
use yii\helpers\ArrayHelper;

return ArrayHelper::merge(
    require(__DIR__ . '/common.php'),
    [
        'components' => [
            'request' => [
                'cookieValidationKey' => getenv('COOKIE_SECRET'),
            ],

            'user' => [
                'identityClass' => UserIdentity::class,
                'enableAutoLogin' => true,
                'loginUrl' => ['/user/default/login'],
            ],
        ],
    ]
);
