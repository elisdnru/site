<?php

declare(strict_types=1);

namespace app\modules\blog\models\query;

use app\modules\blog\models\Post;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\BatchQueryResult;
use yii\db\Connection;

class PostQuery extends ActiveQuery
{
    public function published(): self
    {
        return $this->andWhere('public = 1 AND date <= NOW()');
    }

    /**
     * @param Connection $db
     * @return Post[]
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @param int $batchSize
     * @param Connection $db
     * @return Post[]|BatchQueryResult
     */
    public function each($batchSize = 100, $db = null): iterable
    {
        return parent::each($batchSize, $db);
    }

    /**
     * @param Connection $db
     * @return Post|ActiveRecord|null
     */
    public function one($db = null): ?Post
    {
        return parent::one($db);
    }
}
