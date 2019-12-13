<?php

namespace app\components\category\models;

use app\components\category\behaviors\CategoryTreeQueryBehaviorV2;
use yii\db\ActiveRecord;
use yii\db\BatchQueryResult;
use yii\db\Connection;

/**
 * @mixin CategoryTreeQueryBehaviorV2
 */
class TreeCategoryQueryV2 extends CategoryQueryV2
{
    public function behaviors(): array
    {
        return [
            'CategoryQueryBehavior' => [
                'class' => CategoryTreeQueryBehaviorV2::class,
            ],
        ];
    }

    /**
     * @param Connection $db
     * @return TreeCategoryV2[]
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @param int $batchSize
     * @param Connection $db
     * @return TreeCategoryV2[]|BatchQueryResult
     */
    public function each($batchSize = 100, $db = null): iterable
    {
        return parent::each($batchSize, $db);
    }

    /**
     * @param Connection $db
     * @return TreeCategoryV2|ActiveRecord|null
     */
    public function one($db = null): ?TreeCategoryV2
    {
        return parent::one($db);
    }
}
