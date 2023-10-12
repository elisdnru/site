<?php

declare(strict_types=1);

namespace app\components\category\models;

use app\components\category\behaviors\CategoryQueryBehavior;
use yii\db\ActiveQuery;
use yii\db\BatchQueryResult;
use yii\db\Connection;

/**
 * @mixin CategoryQueryBehavior
 */
class CategoryQuery extends ActiveQuery
{
    public function behaviors(): array
    {
        return [
            'CategoryQueryBehavior' => [
                'class' => CategoryQueryBehavior::class,
                'titleAttribute' => 'title',
                'slugAttribute' => 'slug',
                'defaultOrder' => ['sort' => SORT_ASC, 'title' => SORT_ASC],
            ],
        ];
    }

    /**
     * @param Connection|null $db
     * @return Category[]
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @psalm-suppress ImplementedReturnTypeMismatch
     * @param int $batchSize
     * @param Connection|null $db
     * @return BatchQueryResult|Category[]
     */
    public function each($batchSize = 100, $db = null): array|BatchQueryResult
    {
        return parent::each($batchSize, $db);
    }

    /**
     * @psalm-suppress ImplementedReturnTypeMismatch
     * @param Connection|null $db
     * @psalm-return Category|null
     */
    public function one($db = null): null|array|Category
    {
        return parent::one($db);
    }
}
