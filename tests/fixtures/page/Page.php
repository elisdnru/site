<?php

declare(strict_types=1);

namespace tests\fixtures\page;

use app\modules\page\models\Page as Base;

class Page extends Base
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
