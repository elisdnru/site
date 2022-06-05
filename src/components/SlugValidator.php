<?php

declare(strict_types=1);

namespace app\components;

use yii\validators\RegularExpressionValidator;

final class SlugValidator extends RegularExpressionValidator
{
    /**
     * {@inheritdoc}
     */
    public $pattern = '#^\w[a-zA-Z0-9_-]+$#';

    /**
     * {@inheritdoc}
     */
    public $message = 'Допустимы только латинские символы, цифры и знак подчёркивания';
}
