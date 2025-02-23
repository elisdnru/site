<?php

declare(strict_types=1);

namespace app\modules\landing\models;

use app\components\category\behaviors\CategoryTreeQueryBehavior;
use Override;
use yii\db\ActiveQuery;
use yii\db\BatchQueryResult;
use yii\db\Connection;

/**
 * @mixin CategoryTreeQueryBehavior
 */
final class LandingQuery extends ActiveQuery
{
    #[Override]
    public function behaviors(): array
    {
        return [
            'CategoryQueryBehavior' => [
                'class' => CategoryTreeQueryBehavior::class,
                'titleAttribute' => 'title',
                'slugAttribute' => 'slug',
                'defaultOrder' => ['title' => SORT_ASC],
            ],
        ];
    }

    /**
     * @param Connection|null $db
     * @return Landing[]
     */
    #[Override]
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @psalm-suppress ImplementedReturnTypeMismatch
     * @param int $batchSize
     * @param Connection|null $db
     * @return BatchQueryResult|Landing[]
     */
    #[Override]
    public function each($batchSize = 100, $db = null): array|BatchQueryResult
    {
        return parent::each($batchSize, $db);
    }

    /**
     * @psalm-suppress ImplementedReturnTypeMismatch
     * @param Connection|null $db
     * @psalm-return Landing|null
     */
    #[Override]
    public function one($db = null): null|array|Landing
    {
        return parent::one($db);
    }
}
