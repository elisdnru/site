<?php

namespace app\components;

use CExistValidator;

class ExistOrEmptyValidatorV1 extends CExistValidator
{
    protected function isEmpty($value, $trim = false): bool
    {
        return !$value || parent::isEmpty($value, $trim);
    }
}
