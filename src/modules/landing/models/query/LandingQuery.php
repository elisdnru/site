<?php

declare(strict_types=1);

namespace app\modules\landing\models\query;

use app\components\category\behaviors\CategoryTreeQueryBehavior;
use app\modules\landing\models\Landing;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\BatchQueryResult;
use yii\db\Connection;

/**
 * @mixin CategoryTreeQueryBehavior
 */
class LandingQuery extends ActiveQuery
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
     * @param Connection $db
     * @return Landing[]
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @param int $batchSize
     * @param Connection $db
     * @return Landing[]|BatchQueryResult
     */
    public function each($batchSize = 100, $db = null): iterable
    {
        return parent::each($batchSize, $db);
    }

    /**
     * @param Connection $db
     * @return Landing|ActiveRecord|null
     */
    public function one($db = null): ?Landing
    {
        return parent::one($db);
    }
}
