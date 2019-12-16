<?php

declare(strict_types=1);

namespace app\components\category\behaviors;

use yii\base\Behavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class CategoryQueryBehaviorV2 extends Behavior
{
    public string $titleAttribute = 'title';
    public string $aliasAttribute = 'alias';
    public string $urlAttribute = 'url';
    public ?string $iconAttribute = null;
    public string $linkActiveAttribute = 'linkActive';
    public array $defaultOrder = [];

    public function getArray(): array
    {
        return $this->getQuery()
            ->select(['id'])
            ->column();
    }

    public function getAssocList(): array
    {
        return $this->getQuery()
            ->select([$this->titleAttribute, 'id'])
            ->indexBy('id')
            ->column();
    }

    public function getAliasList(): array
    {
        $rows = $this->getQuery()
            ->select([$this->titleAttribute, $this->aliasAttribute, 'id'])
            ->indexBy('id')
            ->asArray()
            ->all();

        return array_column($rows, $this->titleAttribute, $this->aliasAttribute);
    }

    public function getUrlList(): array
    {
        $items = $this->getQuery()->indexBy($this->aliasAttribute)->all();

        $result = [];
        foreach ($items as $item) {
            $result[$item->{$this->urlAttribute}] = $item->{$this->titleAttribute};
        }
        return $result;
    }

    public function getMenuList(): array
    {
        $items = $this->getQuery()->indexBy($this->aliasAttribute)->all();

        $result = [];
        foreach ($items as $item) {
            $active = $item->{$this->linkActiveAttribute};
            $id = $item->getPrimaryKey();
            $result[$id] = [
                'id' => $id,
                'label' => $item->{$this->titleAttribute},
                'url' => $item->{$this->urlAttribute},
                'icon' => $this->iconAttribute !== null ? $item->{$this->iconAttribute} : '',
                'active' => $active,
                'itemOptions' => ['class' => 'item_' . $id],
                'linkOptions' => $active ? ['rel' => 'nofollow'] : [],
            ];
        }
        return $result;
    }

    public function findByAlias(string $alias): ?ActiveRecord
    {
        return $this->getQuery()->andWhere([$this->aliasAttribute => $alias])->limit(1)->one();
    }

    private function getQuery(): ActiveQuery
    {
        /** @var ActiveQuery $query */
        $query = $this->owner;
        return $query->cache()->orderBy($this->defaultOrder);
    }
}
