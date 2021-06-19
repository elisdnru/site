<?php

declare(strict_types=1);

namespace app\modules\portfolio\models;

use app\components\category\models\TreeCategory;

/**
 * @property Category $parent
 * @property Category[] $children
 */
class Category extends TreeCategory
{
    public string $urlRoute = '/portfolio/default/category';

    public static function tableName(): string
    {
        return 'portfolio_categories';
    }

    public function rules(): array
    {
        return array_merge(parent::rules(), [
            ['text', 'string'],
        ]);
    }
}
