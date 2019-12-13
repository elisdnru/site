<?php

namespace app\components\category\models;

use app\components\category\behaviors\CategoryQueryBehaviorV2;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\BatchQueryResult;
use yii\db\Connection;

/**
 * @mixin CategoryQueryBehaviorV2
 */
class CategoryQueryV2 extends ActiveQuery
{
    public function behaviors(): array
    {
        return [
            'CategoryQueryBehavior' => [
                'class' => CategoryQueryBehaviorV2::class,
            ],
        ];
    }

    /**
     * @param Connection $db
     * @return CategoryV2[]
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @param int $batchSize
     * @param Connection $db
     * @return CategoryV2[]|BatchQueryResult
     */
    public function each($batchSize = 100, $db = null): iterable
    {
        return parent::each($batchSize, $db);
    }

    /**
     * @param Connection $db
     * @return CategoryV2|ActiveRecord|null
     */
    public function one($db = null): ?CategoryV2
    {
        return parent::one($db);
    }
}
