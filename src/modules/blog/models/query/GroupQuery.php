<?php

declare(strict_types=1);

namespace app\modules\blog\models\query;

use app\components\category\behaviors\CategoryQueryBehavior;
use app\modules\blog\models\Group;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\BatchQueryResult;
use yii\db\Connection;

/**
 * @mixin CategoryQueryBehavior
 */
class GroupQuery extends ActiveQuery
{
    public function behaviors(): array
    {
        return [
            'CategoryQueryBehavior' => [
                'class' => CategoryQueryBehavior::class,
                'titleAttribute' => 'title',
                'aliasAttribute' => 'alias',
                'defaultOrder' => ['title' => SORT_ASC],
            ],
        ];
    }

    /**
     * @param Connection|null $db
     * @return Group[]
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @param int $batchSize
     * @param Connection|null $db
     * @return Group[]|BatchQueryResult
     */
    public function each($batchSize = 100, $db = null): iterable
    {
        return parent::each($batchSize, $db);
    }

    /**
     * @param Connection|null $db
     * @return Group|ActiveRecord|null
     */
    public function one($db = null): ?Group
    {
        return parent::one($db);
    }
}
