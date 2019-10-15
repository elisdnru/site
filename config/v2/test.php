<?php

use yii\helpers\ArrayHelper;

return ArrayHelper::merge(
    require(__DIR__ . '/common.php'),
    require(__DIR__ . '/web.php'),
    [
        'components' => [],

        'params' => [],
    ]
);
