<?php

declare(strict_types=1);

namespace app\modules\user\components;

use yii\validators\RegularExpressionValidator;

final class UsernameValidator extends RegularExpressionValidator
{
    public $pattern = '#^[a-zA-Z0-9_\.-]+$#';

    public $message = 'Логин содержит запрещённые символы.';
}
