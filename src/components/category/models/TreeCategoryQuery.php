<?php

namespace app\components\category\models;

use app\components\category\behaviors\CategoryTreeQueryBehavior;
use yii\db\ActiveRecord;
use yii\db\BatchQueryResult;
use yii\db\Connection;

/**
 * @mixin CategoryTreeQueryBehavior
 */
class TreeCategoryQuery extends CategoryQuery
{
    public function behaviors(): array
    {
        return [
            'CategoryQueryBehavior' => [
                'class' => CategoryTreeQueryBehavior::class,
                'titleAttribute' => 'title',
                'aliasAttribute' => 'alias',
                'defaultOrder' => ['sort' => SORT_ASC, 'title' => SORT_ASC],
            ],
        ];
    }

    /**
     * @param Connection $db
     * @return TreeCategory[]
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @param int $batchSize
     * @param Connection $db
     * @return TreeCategory[]|BatchQueryResult
     */
    public function each($batchSize = 100, $db = null): iterable
    {
        return parent::each($batchSize, $db);
    }

    /**
     * @param Connection $db
     * @return TreeCategory|ActiveRecord|null
     */
    public function one($db = null): ?TreeCategory
    {
        return parent::one($db);
    }
}
