<?php

declare(strict_types=1);

namespace app\modules\comment\models\query;

use app\modules\comment\models\Comment;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\BatchQueryResult;
use yii\db\Connection;

class CommentQuery extends ActiveQuery
{
    public function init(): void
    {
        /**
         * @var Comment $class
         * @psalm-var class-string<Comment> $class
         */
        $class = $this->modelClass;

        if ($class::TYPE_OF_COMMENT) {
            $this->type((string)$class::TYPE_OF_COMMENT);
        }

        parent::init();
    }

    public function published(): self
    {
        return $this->andWhere(['public' => 1]);
    }

    public function material(int $id): self
    {
        return $this->andWhere(['material_id' => $id]);
    }

    public function type(string $type): self
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
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @psalm-suppress ImplementedReturnTypeMismatch
     * @param int $batchSize
     * @param Connection|null $db
     * @return Comment[]|BatchQueryResult
     */
    public function each($batchSize = 100, $db = null): array|BatchQueryResult
    {
        return parent::each($batchSize, $db);
    }

    /**
     * @psalm-suppress ImplementedReturnTypeMismatch
     * @param Connection|null $db
     * @return Comment|array|null
     * @psalm-return Comment|null
     */
    public function one($db = null): array|Comment|null
    {
        return parent::one($db);
    }
}
