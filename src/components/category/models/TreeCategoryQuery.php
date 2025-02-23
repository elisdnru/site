<?php

declare(strict_types=1);

namespace app\components\category\models;

use app\components\category\behaviors\CategoryTreeQueryBehavior;
use Override;

/**
 * @extends CategoryQuery<TreeCategory>
 * @mixin CategoryTreeQueryBehavior
 */
final class TreeCategoryQuery extends CategoryQuery
{
    #[Override]
    public function behaviors(): array
    {
        return [
            'CategoryQueryBehavior' => [
                'class' => CategoryTreeQueryBehavior::class,
                'titleAttribute' => 'title',
                'slugAttribute' => 'slug',
                'defaultOrder' => ['sort' => SORT_ASC, 'title' => SORT_ASC],
            ],
        ];
    }
}
