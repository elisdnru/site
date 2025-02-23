<?php

declare(strict_types=1);

namespace app\modules\landing\models;

use app\components\category\behaviors\CategoryTreeQueryBehavior;
use Override;
use yii\db\ActiveQuery;

/**
 * @extends ActiveQuery<Landing>
 * @mixin CategoryTreeQueryBehavior
 */
final class LandingQuery extends ActiveQuery
{
    #[Override]
    public function behaviors(): array
    {
        return [
            'CategoryQueryBehavior' => [
                'class' => CategoryTreeQueryBehavior::class,
                'titleAttribute' => 'title',
                'slugAttribute' => 'slug',
                'defaultOrder' => ['title' => SORT_ASC],
            ],
        ];
    }
}
