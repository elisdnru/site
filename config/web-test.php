<?php

declare(strict_types=1);

use yii\helpers\ArrayHelper;

return ArrayHelper::merge(
    require(__DIR__ . '/web.php'),
    []
);
