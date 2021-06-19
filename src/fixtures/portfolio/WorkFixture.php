<?php

declare(strict_types=1);

namespace app\fixtures\portfolio;

use app\modules\portfolio\models\Work;
use yii\test\ActiveFixture;

class WorkFixture extends ActiveFixture
{
    public $modelClass = Work::class;
    public $dataFile = __DIR__ . '/work.php';
}
