<?php

declare(strict_types=1);

namespace app\modules\blog\models;

use app\components\category\models\TreeCategory;
use app\components\ForceActiveRecordErrors;
use Override;

final class Category extends TreeCategory
{
    use ForceActiveRecordErrors;

    public string $urlRoute = '/blog/default/category';

    #[Override]
    public static function tableName(): string
    {
        return 'blog_categories';
    }

    #[Override]
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            ['text', 'string'],
        ]);
    }
}
