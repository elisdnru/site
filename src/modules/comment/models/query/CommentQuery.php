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
    public function init()
    {
        /** @var Comment $class */
        $class = $this->modelClass;

        if ($class::TYPE_OF_COMMENT) {
            $this->type($class::TYPE_OF_COMMENT);
        }

        parent::init();
    }

    public function published(): self
    {
        return $this->andWhere(['public' => 1]);
    }

    public function material($id): self
    {
        if ($id) {
            return $this->andWhere(['material_id' => $id]);
        }
        return $this;
    }

    public function type($type): self
    {
        if ($type) {
            return $this->andWhere(['type' => $type]);
        }
        return $this;
    }

    public function user($id): self
    {
        if ($id) {
            return $this->andWhere(['user_id' => $id]);
        }
        return $this;
    }

    public function unread(): self
    {
        return $this->andWhere(['moder' => 0]);
    }

    /**
     * @param Connection $db
     * @return Comment[]
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @param int $batchSize
     * @param Connection $db
     * @return Comment[]|BatchQueryResult
     */
    public function each($batchSize = 100, $db = null): iterable
    {
        return parent::each($batchSize, $db);
    }

    /**
     * @param Connection $db
     * @return Comment|ActiveRecord
     */
    public function one($db = null): Comment
    {
        return parent::one($db);
    }
}
