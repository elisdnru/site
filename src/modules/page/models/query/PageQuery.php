<?php

declare(strict_types=1);

namespace app\modules\page\models\query;

use app\components\category\behaviors\CategoryTreeQueryBehaviorV2;
use app\modules\page\models\Page;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\BatchQueryResult;
use yii\db\Connection;

/**
 * @mixin CategoryTreeQueryBehaviorV2
 */
class PageQuery extends ActiveQuery
{
    public function behaviors(): array
    {
        return [
            'CategoryQueryBehavior' => [
                'class' => CategoryTreeQueryBehaviorV2::class,
                'titleAttribute' => 'title',
                'aliasAttribute' => 'alias',
                'defaultOrder' => ['title' => SORT_ASC],
            ],
        ];
    }

    /**
     * @param Connection $db
     * @return Page[]
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @param int $batchSize
     * @param Connection $db
     * @return Page[]|BatchQueryResult
     */
    public function each($batchSize = 100, $db = null): iterable
    {
        return parent::each($batchSize, $db);
    }

    /**
     * @param Connection $db
     * @return Page|ActiveRecord|null
     */
    public function one($db = null): ?Page
    {
        return parent::one($db);
    }
}