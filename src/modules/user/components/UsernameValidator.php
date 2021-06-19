<?php

declare(strict_types=1);

namespace app\modules\user\components;

use yii\validators\RegularExpressionValidator;

class UsernameValidator extends RegularExpressionValidator
{
    /**
     * {@inheritdoc}
     */
    public $pattern = '#^[a-zA-Z0-9_\.-]+$#';

    /**
     * {@inheritdoc}
     */
    public $message = 'Логин содержит запрещённые символы.';
}
