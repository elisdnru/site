<?php

declare(strict_types=1);

namespace app\modules\comment\models;

use yii\db\ActiveQuery;

/**
 * @extends ActiveQuery<Comment>
 */
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
}
