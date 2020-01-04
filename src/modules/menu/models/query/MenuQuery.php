<?php

declare(strict_types=1);

namespace app\modules\menu\models\query;

use app\components\category\behaviors\CategoryTreeQueryBehaviorV2;
use app\modules\menu\models\Menu;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\BatchQueryResult;
use yii\db\Connection;

/**
 * @mixin CategoryTreeQueryBehaviorV2
 */
class MenuQuery extends ActiveQuery
{
    public function visible(): self
    {
        return $this->andWhere(['visible' => true]);
    }

    public function getMenuListByAlias(string $alias, int $sub = 0): array
    {
        $parent = (clone $this)->andWhere(['alias' => $alias])->one();

        if ($parent === null) {
            return [];
        }

        return $this->getMenuList($sub, $parent->id);
    }

    public function behaviors(): array
    {
        return [
            'CategoryQueryBehavior' => [
                'class' => CategoryTreeQueryBehaviorV2::class,
                'titleAttribute' => 'title',
                'aliasAttribute' => 'alias',
                'defaultOrder' => ['sort' => SORT_ASC, 'title' => SORT_ASC],
            ],
        ];
    }

    /**
     * @param Connection $db
     * @return Menu[]
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @param int $batchSize
     * @param Connection $db
     * @return Menu[]|BatchQueryResult
     */
    public function each($batchSize = 100, $db = null): iterable
    {
        return parent::each($batchSize, $db);
    }

    /**
     * @param Connection $db
     * @return Menu|ActiveRecord|null
     */
    public function one($db = null): ?Menu
    {
        return parent::one($db);
    }
}
