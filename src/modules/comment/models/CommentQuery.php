<?php

declare(strict_types=1);

namespace app\modules\comment\models;

use Override;
use yii\db\ActiveQuery;
use yii\db\BatchQueryResult;
use yii\db\Connection;

final class CommentQuery extends ActiveQuery
{
    public function published(): self
    {
        return $this->andWhere(['public' => 1]);
    }

    public function material(int $id): self
    {
        return $this->andWhere(['material_id' => $id]);
    }

    public function type(?string $type): self
    {
        return $this->andWhere(['type' => $type]);
    }

    public function user(int $id): self
    {
        return $this->andWhere(['user_id' => $id]);
    }

    public function unread(): self
    {
        return $this->andWhere(['moder' => 0]);
    }

    /**
     * @param Connection|null $db
     * @return Comment[]
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
     * @return BatchQueryResult|Comment[]
     */
    #[Override]
    public function each($batchSize = 100, $db = null): array|BatchQueryResult
    {
        return parent::each($batchSize, $db);
    }

    /**
     * @psalm-suppress ImplementedReturnTypeMismatch
     * @param Connection|null $db
     * @psalm-return Comment|null
     */
    #[Override]
    public function one($db = null): null|array|Comment
    {
        return parent::one($db);
    }
}
