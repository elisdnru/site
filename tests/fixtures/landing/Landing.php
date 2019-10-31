<?php

declare(strict_types=1);

namespace tests\fixtures\landing;

use app\modules\landing\models\Landing as Base;

class Landing extends Base
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
