<?php

declare(strict_types=1);

namespace app\components\category\behaviors;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class CategoryTreeQueryBehavior extends CategoryQueryBehavior
{
    public string $parentAttribute = 'parent_id';

    /**
     * @return ActiveQuery|self
     */
    public function roots(): ActiveQuery
    {
        return $this->getQuery()->andWhere(['parent_id' => null]);
    }

    public function getAssocList($parent = null): array
    {
        $items = $this->getFullAssocData([
            $this->primaryKeyAttribute,
            $this->titleAttribute,
            $this->parentAttribute,
        ], $parent);

        $associated = [];
        foreach ($items as $item) {
            $associated[$item[$this->primaryKeyAttribute]] = $item;
        }
        $items = $associated;

        $result = [];

        foreach ($items as $item) {
            $titles = [$item[$this->titleAttribute]];

            $temp = $item;
            while (isset($items[(int)$temp[$this->parentAttribute]])) {
                $titles[] = $items[(int)$temp[$this->parentAttribute]][$this->titleAttribute];
                $temp = $items[(int)$temp[$this->parentAttribute]];
            }

            $result[$item[$this->primaryKeyAttribute]] = implode(' - ', array_reverse($titles));
        }

        return $result;
    }

    public function getAliasList($parent = null): array
    {
        $items = $this->getFullAssocData([
            $this->aliasAttribute,
            $this->titleAttribute,
            $this->parentAttribute,
        ], $parent);

        $associated = [];
        foreach ($items as $item) {
            $associated[$item[$this->aliasAttribute]] = $item;
        }
        $items = $associated;

        $result = [];

        foreach ($items as $item) {
            $titles = [$item[$this->titleAttribute]];

            $temp = $item;
            while (isset($items[(int)$temp[$this->parentAttribute]])) {
                $titles[] = $items[(int)$temp[$this->parentAttribute]][$this->titleAttribute];
                $temp = $items[(int)$temp[$this->parentAttribute]];
            }

            $result[$item[$this->aliasAttribute]] = implode(' - ', array_reverse($titles));
        }

        return $result;
    }

    public function getTabList($parent = null): array
    {
        $parents = $this->processParents($parent);

        $items = $this->getFullAssocData([
            $this->primaryKeyAttribute,
            $this->titleAttribute,
            $this->parentAttribute
        ], $parent);

        $result = [];
        foreach ($parents as $parent_id) {
            $this->getTabListRecursive($items, $result, $parent_id);
        }

        return $result;
    }

    protected function getTabListRecursive(array &$items, array &$result, $parent_id, int $indent = 0): void
    {
        foreach ($items as $item) {
            if ((int)$item[$this->parentAttribute] === (int)$parent_id && !isset($result[$item[$this->primaryKeyAttribute]])) {
                $result[$item[$this->primaryKeyAttribute]] = str_repeat('-- ', $indent) . $item[$this->titleAttribute];
                $this->getTabListRecursive($items, $result, $item[$this->primaryKeyAttribute], $indent + 1);
            }
        }
    }

    public function getUrlList($parent = null): array
    {
        $query = $this->getQuery();

        if ($parent !== null) {
            $query->andWhere([$this->primaryKeyAttribute => $this->getChildrenArray($parent)]);
        }

        $items = $query->all();

        $categories = [];
        foreach ($items as $item) {
            $categories[(int)$item->{$this->parentAttribute}][] = $item;
        }

        return $this->getUrlListRecursive($categories, $parent);
    }

    protected function getUrlListRecursive(array $items, $parent, int $indent = 0): array
    {
        $parent = (int)$parent;
        $resultArray = [];
        if (isset($items[$parent]) && $items[$parent]) {
            foreach ($items[$parent] as $item) {
                $resultArray = $resultArray + [$item->{$this->urlAttribute} => str_repeat('-- ', $indent) . $item->{$this->titleAttribute}] + $this->getUrlListRecursive($items, $item->getPrimaryKey(), $indent + 1);
            }
        }
        return $resultArray;
    }

    public function getMenuList(string $path, int $sub = 0, $parent = null): array
    {
        $query = $this->getQuery();

        if ($parent !== null) {
            $query->andWhere([$this->primaryKeyAttribute => $this->getChildrenArray($parent)]);
        }

        $items = $query->all();

        $categories = [];
        foreach ($items as $item) {
            $categories[(int)$item->{$this->parentAttribute}][] = $item;
        }

        return $this->getMenuListRecursive($path, $categories, $parent, $sub);
    }

    protected function getMenuListRecursive(string $path, array $items, $parent, $sub): array
    {
        $parent = (int)$parent;
        $resultArray = [];
        if (isset($items[$parent]) && $items[$parent]) {
            foreach ($items[$parent] as $item) {
                $id = $item->getPrimaryKey();
                $resultArray[$id] = [
                        'id' => $id,
                        'label' => $item->{$this->titleAttribute},
                        'url' => $item->{$this->urlAttribute},
                        'icon' => $this->iconAttribute !== null ? $item->{$this->iconAttribute} : '',
                        'active' => $item->isLinkActive($path),
                    ] + (
                        $sub
                        ? ['items' => $this->getMenuListRecursive($path, $items, $item->getPrimaryKey(), $sub - 1)]
                        : []
                    );
            }
        }
        return $resultArray;
    }

    public function findByPath(string $path): ?ActiveRecord
    {
        $chunks = explode('/', trim($path, '/'));
        $model = null;

        $query = $this->getQuery();

        if (count($chunks) === 1) {
            $query
                ->andWhere([$this->aliasAttribute => $chunks[0]])
                ->andWhere(['or', [$this->parentAttribute => null], [$this->parentAttribute => 0]]);
            $model = $query->limit(1)->one();
        } else {
            $query->andWhere([$this->aliasAttribute => $chunks[0]]);
            /** @var ActiveRecord|CategoryTreeBehavior $parent */
            $parent = $query->limit(1)->one();

            if ($parent !== null) {
                $chunks = array_slice($chunks, 1);
                foreach ($chunks as $alias) {
                    $model = $parent->getChildByAlias($alias, $this->getQuery());
                    if (!$model) {
                        return null;
                    }
                    $parent = $model;
                }
            }
        }
        return $model;
    }

    public function getChildrenArray($parent = null): array
    {
        $parents = $this->processParents($parent);

        $items = $this->getQuery()
            ->select([$this->primaryKeyAttribute, $this->titleAttribute, $this->parentAttribute])
            ->all();

        $result = [];

        foreach ($parents as $parent_id) {
            $this->childrenArrayRecursive($items, $result, $parent_id);
        }

        return array_unique($result);
    }

    protected function childrenArrayRecursive(array &$items, array &$result, $parent_id): void
    {
        foreach ($items as $item) {
            if ((int)$item[$this->parentAttribute] === (int)$parent_id) {
                $result[] = $item[$this->primaryKeyAttribute];
                $this->childrenArrayRecursive($items, $result, $item[$this->primaryKeyAttribute]);
            }
        }
    }

    protected function processParents($parent): array
    {
        return $this->arrayFromArgs($parent);
    }

    protected function arrayFromArgs($items): array
    {
        $array = [];

        if (!$items) {
            $items = [0];
        } elseif (!is_array($items)) {
            $items = [$items];
        }

        foreach ($items as $item) {
            if (is_object($item)) {
                $array[] = $item->getPrimaryKey();
            } else {
                $array[] = $item;
            }
        }

        return array_unique($array);
    }

    protected function getFullAssocData(array $attributes, $parent = null): array
    {
        $query = $this->getQuery();

        $attributes = array_unique(array_merge($attributes, [$this->primaryKeyAttribute]));

        $query->select(array_combine($attributes, $attributes));

        if ($parent !== null) {
            $query->andWhere([$this->primaryKeyAttribute => array_merge([$parent], $this->getChildrenArray($parent))]);
        }

        return $query->all();
    }
}
