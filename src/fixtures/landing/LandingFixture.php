<?php

declare(strict_types=1);

namespace app\fixtures\landing;

use app\modules\landing\models\Landing;
use yii\test\ActiveFixture;

class LandingFixture extends ActiveFixture
{
    public $modelClass = Landing::class;
    public $dataFile = __DIR__ . '/landing.php';
}
