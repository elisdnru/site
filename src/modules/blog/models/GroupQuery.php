<?php

declare(strict_types=1);

namespace app\modules\blog\models;

use app\components\category\behaviors\CategoryQueryBehavior;
use Override;
use yii\db\ActiveQuery;

/**
 * @extends ActiveQuery<Group>
 * @mixin CategoryQueryBehavior
 */
final class GroupQuery extends ActiveQuery
{
    #[Override]
    public function behaviors(): array
    {
        return [
            'CategoryQueryBehavior' => [
                'class' => CategoryQueryBehavior::class,
                'titleAttribute' => 'title',
                'slugAttribute' => 'slug',
                'defaultOrder' => ['title' => SORT_ASC],
            ],
        ];
    }
}
