<?php

declare(strict_types=1);

namespace tests\fixtures\landing;

use app\modules\landing\models\Landing;
use yii\test\ActiveFixture;

class LandingFixture extends ActiveFixture
{
    public $modelClass = Landing::class;
    public $dataFile = __DIR__ . '/../../_data/fixtures/landings.php';
}
