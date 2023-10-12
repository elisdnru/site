<?php

declare(strict_types=1);

namespace app\modules\portfolio\models;

use yii\db\ActiveQuery;
use yii\db\BatchQueryResult;
use yii\db\Connection;

final class WorkQuery extends ActiveQuery
{
    public function published(): self
    {
        return $this->andWhere(['public' => 1]);
    }

    public function category(int $id): self
    {
        return $this->andWhere(['category_id' => $id]);
    }

    /**
     * @param Connection|null $db
     * @return Work[]
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @psalm-suppress ImplementedReturnTypeMismatch
     * @param int $batchSize
     * @param Connection|null $db
     * @return BatchQueryResult|Work[]
     */
    public function each($batchSize = 100, $db = null): array|BatchQueryResult
    {
        return parent::each($batchSize, $db);
    }

    /**
     * @psalm-suppress ImplementedReturnTypeMismatch
     * @param Connection|null $db
     * @psalm-return Work|null
     */
    public function one($db = null): null|array|Work
    {
        return parent::one($db);
    }
}
