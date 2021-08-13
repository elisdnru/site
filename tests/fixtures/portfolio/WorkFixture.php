<?php

declare(strict_types=1);

namespace tests\fixtures\portfolio;

use app\modules\portfolio\models\Work;
use yii\test\ActiveFixture;

final class WorkFixture extends ActiveFixture
{
    public $modelClass = Work::class;
    public $dataFile = __DIR__ . '/../../_data/fixtures/portfolio_works.php';
}
