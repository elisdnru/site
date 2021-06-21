<?php

declare(strict_types=1);

namespace app\fixtures\user;

use app\modules\user\models\User;
use yii\test\ActiveFixture;

class UserFixture extends ActiveFixture
{
    public $modelClass = User::class;
    public $dataFile = __DIR__ . '/data/user.php';
}
