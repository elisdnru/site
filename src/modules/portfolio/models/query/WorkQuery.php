<?php

declare(strict_types=1);

namespace app\modules\portfolio\models\query;

use app\modules\portfolio\models\Work;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Connection;

class WorkQuery extends ActiveQuery
{
    public function published(): self
    {
        return $this->andWhere(['public' => 1]);
    }

    public function category($id): self
    {
        return $this->andWhere(['category_id' => $id]);
    }

    /**
     * @param Connection $db
     * @return Work[]
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @param Connection $db
     * @return Work|ActiveRecord
     */
    public function one($db = null): Work
    {
        return parent::one($db);
    }
}
