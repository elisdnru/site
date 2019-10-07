<?php

declare(strict_types=1);

namespace app\components;

use CActiveRecord;

class ActiveRecord extends CActiveRecord
{
    /**
     * @param string|null $className
     * @return CActiveRecord|static
     */
    public static function model($className = null)
    {
        return parent::model($className ?: static::class);
    }
}
