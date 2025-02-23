<?php

declare(strict_types=1);

namespace app\modules\blog\models;

use Override;
use yii\db\ActiveQuery;
use yii\db\BatchQueryResult;
use yii\db\Connection;

final class PostQuery extends ActiveQuery
{
    public function published(): self
    {
        return $this->andWhere([
            'and',
            ['public' => 1],
            ['<=', 'date', date('Y-m-d H:i:s')],
        ]);
    }

    /**
     * @param Connection|null $db
     * @return Post[]
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
     * @return BatchQueryResult|Post[]
     */
    #[Override]
    public function each($batchSize = 100, $db = null): array|BatchQueryResult
    {
        return parent::each($batchSize, $db);
    }

    /**
     * @psalm-suppress ImplementedReturnTypeMismatch
     * @param Connection|null $db
     * @psalm-return Post|null
     */
    #[Override]
    public function one($db = null): null|array|Post
    {
        return parent::one($db);
    }
}
