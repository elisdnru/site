<?php

declare(strict_types=1);

namespace app\modules\blog\models;

use yii\db\ActiveQuery;

/**
 * @extends ActiveQuery<Post>
 */
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
}
