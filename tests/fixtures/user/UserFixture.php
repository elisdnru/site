<?php

declare(strict_types=1);

namespace tests\fixtures\user;

use app\modules\user\models\User;
use yii\test\ActiveFixture;

class UserFixture extends ActiveFixture
{
    public $modelClass = User::class;
}
