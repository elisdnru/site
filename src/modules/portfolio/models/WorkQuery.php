<?php

declare(strict_types=1);

namespace app\modules\portfolio\models;

use yii\db\ActiveQuery;

/**
 * @extends ActiveQuery<Work>
 */
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
}
