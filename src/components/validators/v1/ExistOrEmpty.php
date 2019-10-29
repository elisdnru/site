<?php

namespace app\components\validators\v1;

use CExistValidator;

class ExistOrEmpty extends CExistValidator
{
    protected function isEmpty($value, $trim = false): bool
    {
        return !$value || parent::isEmpty($value, $trim);
    }
}
