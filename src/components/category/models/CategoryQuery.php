<?php

declare(strict_types=1);

namespace app\components\category\models;

use app\components\category\behaviors\CategoryQueryBehavior;
use Override;
use yii\db\ActiveQuery;

/**
 * @template T of Category
 * @extends ActiveQuery<T>
 * @mixin CategoryQueryBehavior
 */
class CategoryQuery extends ActiveQuery
{
    #[Override]
    public function behaviors(): array
    {
        return [
            'CategoryQueryBehavior' => [
                'class' => CategoryQueryBehavior::class,
                'titleAttribute' => 'title',
                'slugAttribute' => 'slug',
                'defaultOrder' => ['sort' => SORT_ASC, 'title' => SORT_ASC],
            ],
        ];
    }
}
