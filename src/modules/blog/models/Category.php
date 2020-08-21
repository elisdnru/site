<?php

namespace app\modules\blog\models;

use app\components\category\models\TreeCategory;

class Category extends TreeCategory
{
    public string $urlRoute = '/blog/default/category';

    public static function tableName(): string
    {
        return 'blog_categories';
    }

    public function rules(): array
    {
        return array_merge(parent::rules(), [
            ['text', 'string'],
        ]);
    }
}
