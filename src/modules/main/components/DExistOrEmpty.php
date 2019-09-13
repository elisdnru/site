<?php

namespace app\modules\main\components;

use CExistValidator;

class DExistOrEmpty extends CExistValidator
{
    protected function isEmpty($value, $trim = false)
    {
        return !$value || parent::isEmpty($value, $trim);
    }
}
