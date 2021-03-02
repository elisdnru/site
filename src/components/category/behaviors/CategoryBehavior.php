<?php

namespace app\components\category\behaviors;

use app\components\category\Attribute;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class CategoryBehavior extends Behavior
{
    public string $aliasAttribute = 'alias';

    public function isLinkActive(string $path): bool
    {
        $alias = Attribute::string($this->getModel(), $this->aliasAttribute);
        return mb_strpos($path, $alias, 0, 'UTF-8') === 0;
    }

    public function getUrl(): string
    {
        return '#';
    }

    protected function getModel(): ActiveRecord
    {
        /** @var ActiveRecord $owner */
        $owner = $this->owner;
        return $owner;
    }
}
