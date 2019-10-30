<?php

declare(strict_types=1);

namespace tests\fixtures\portfolio;

use app\modules\portfolio\models\Category as Base;

class Category extends Base
{
    public static function findOne($pk)
    {
        return Base::model()->findByAttributes($pk);
    }

    public function primaryKey()
    {
        return ['id'];
    }
}
