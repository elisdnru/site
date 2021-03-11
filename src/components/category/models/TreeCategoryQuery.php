<?php

namespace app\components\category\models;

use app\components\category\behaviors\CategoryTreeQueryBehavior;
use yii\db\ActiveQuery;
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
     * @param Connection|null $db
     * @return TreeCategory[]
     */
    public function all($db = null): array
    {
        return ActiveQuery::all($db);
    }

    /**
     * @psalm-suppress ImplementedReturnTypeMismatch
     * @param int $batchSize
     * @param Connection|null $db
     * @return TreeCategory[]|BatchQueryResult
     */
    public function each($batchSize = 100, $db = null): array|BatchQueryResult
    {
        return ActiveQuery::each($batchSize, $db);
    }

    /**
     * @psalm-suppress ImplementedReturnTypeMismatch
     * @param Connection|null $db
     * @return TreeCategory|array|null
     * @psalm-return TreeCategory|null
     */
    public function one($db = null): array|TreeCategory|null
    {
        return ActiveQuery::one($db);
    }
}
