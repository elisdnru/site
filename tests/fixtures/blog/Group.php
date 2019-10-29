<?php

declare(strict_types=1);

namespace tests\fixtures\blog;

use app\modules\blog\models\Group as Base;

class Group extends Base
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
