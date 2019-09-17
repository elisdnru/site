<?php

namespace app\modules\main\components;

use CExistValidator;

class ExistOrEmpty extends CExistValidator
{
    protected function isEmpty($value, $trim = false)
    {
        return !$value || parent::isEmpty($value, $trim);
    }
}
