<?php

declare(strict_types=1);

use yii\helpers\ArrayHelper;
use yii\web\Request;

return ArrayHelper::merge(
    require(__DIR__ . '/web.php'),
    []
);
