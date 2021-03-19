<?php

declare(strict_types=1);

namespace app\modules\page\models\query;

use app\components\category\behaviors\CategoryTreeQueryBehavior;
use app\modules\page\models\Page;
use yii\db\ActiveQuery;
use yii\db\BatchQueryResult;
use yii\db\Connection;

/**
 * @mixin CategoryTreeQueryBehavior
 */
class PageQuery extends ActiveQuery
{
    public function behaviors(): array
    {
        return [
            'CategoryQueryBehavior' => [
                'class' => CategoryTreeQueryBehavior::class,
                'titleAttribute' => 'title',
                'aliasAttribute' => 'alias',
                'defaultOrder' => ['title' => SORT_ASC],
            ],
        ];
    }

    /**
     * @param Connection|null $db
     * @return Page[]
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @psalm-suppress ImplementedReturnTypeMismatch
     * @param int $batchSize
     * @param Connection|null $db
     * @return Page[]|BatchQueryResult
     */
    public function each($batchSize = 100, $db = null): array|BatchQueryResult
    {
        return parent::each($batchSize, $db);
    }

    /**
     * @psalm-suppress ImplementedReturnTypeMismatch
     * @param Connection|null $db
     * @return Page|array|null
     * @psalm-return Page|null
     */
    public function one($db = null): array|Page|null
    {
        return parent::one($db);
    }
}
