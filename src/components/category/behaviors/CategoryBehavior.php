<?php

declare(strict_types=1);

namespace app\components\category\behaviors;

use app\components\category\Attribute;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class CategoryBehavior extends Behavior
{
    public string $slugAttribute = 'slug';

    public function isLinkActive(string $path): bool
    {
        $slug = Attribute::string($this->getModel(), $this->slugAttribute);
        return mb_strpos($path, $slug, 0, 'UTF-8') === 0;
    }

    public function getUrl(): string
    {
        return '#';
    }

    protected function getModel(): ActiveRecord
    {
        /** @var ActiveRecord */
        return $this->owner;
    }
}
