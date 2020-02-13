<?php

namespace app\components\category\behaviors;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class CategoryBehavior extends Behavior
{
    public string $aliasAttribute = 'alias';
    public string $linkActiveAttribute = 'linkActive';
    public string $requestPathAttribute = 'path';

    public function getLinkActive(): bool
    {
        return mb_strpos(Yii::$app->request->get($this->requestPathAttribute), $this->getModel()->{$this->aliasAttribute}, null, 'UTF-8') === 0;
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
