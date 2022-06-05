<?php

declare(strict_types=1);

namespace app\components\category\behaviors;

use app\components\category\Attribute;
use app\components\category\models\TreeCategory;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

final class CategoryTreeQueryBehavior extends CategoryQueryBehavior
{
    public string $parentAttribute = 'parent_id';

    public function roots(): ActiveQuery
    {
        return $this->getQuery()->andWhere([$this->parentAttribute => null]);
    }

    public function getAssocList(int $parent = null): array
    {
        $items = $this->getFullAssocData([
            $this->primaryKeyAttribute,
            $this->titleAttribute,
            $this->parentAttribute,
        ], $parent);

        $associated = [];
        foreach ($items as $item) {
            $associated[Attribute::int($item, $this->primaryKeyAttribute)] = $item;
        }
        $items = $associated;

        $result = [];

        foreach ($items as $item) {
            $titles = [Attribute::string($item, $this->titleAttribute)];

            $temp = $item;
            while (isset($items[Attribute::intOrNull($temp, $this->parentAttribute) ?: -1])) {
                $titles[] = Attribute::string(
                    $items[Attribute::intOrNull($temp, $this->parentAttribute) ?: -1],
                    $this->titleAttribute
                );
                $temp = $items[Attribute::intOrNull($temp, $this->parentAttribute) ?: -1];
            }

            $result[Attribute::int($item, $this->primaryKeyAttribute)] = implode(' - ', array_reverse($titles));
        }

        return $result;
    }

    public function getSlugList(int $parent = null): array
    {
        $items = $this->getFullAssocData([
            $this->slugAttribute,
            $this->titleAttribute,
            $this->parentAttribute,
        ], $parent);

        $associated = [];
        foreach ($items as $item) {
            $associated[Attribute::int($item, $this->primaryKeyAttribute)] = $item;
        }
        $items = $associated;

        $result = [];

        foreach ($items as $item) {
            $titles = [Attribute::string($item, $this->titleAttribute)];

            $temp = $item;
            while (isset($items[Attribute::intOrNull($temp, $this->parentAttribute) ?: -1])) {
                $titles[] = Attribute::string(
                    $items[Attribute::intOrNull($temp, $this->parentAttribute) ?: -1],
                    $this->titleAttribute
                );
                $temp = $items[Attribute::intOrNull($temp, $this->parentAttribute) ?: -1];
            }

            $result[Attribute::string($item, $this->slugAttribute)] = implode(' - ', array_reverse($titles));
        }

        return $result;
    }

    public function getTabList(int $parent = null): array
    {
        $items = $this->getFullAssocData([
            $this->primaryKeyAttribute,
            $this->titleAttribute,
            $this->parentAttribute,
        ], $parent);

        /** @var string[] $result */
        $result = [];

        $this->getTabListRecursive($items, $result, $parent);

        return $result;
    }

    public function getUrlList(int $parent = null): array
    {
        $query = $this->getQuery();

        if ($parent !== null) {
            $query->andWhere([$this->primaryKeyAttribute => $this->getChildrenArray($parent)]);
        }

        /** @var ActiveRecord[] $items */
        $items = $query->all();

        /** @var ActiveRecord[][] $categories */
        $categories = [];
        foreach ($items as $item) {
            $categories[Attribute::intOrNull($item, $this->parentAttribute) ?: 0][] = $item;
        }

        return $this->getUrlListRecursive($categories, $parent ?: 0);
    }

    public function getMenuList(string $path, int $sub = 0, int $parent = null): array
    {
        $query = $this->getQuery();

        if ($parent !== null) {
            $query->andWhere([$this->primaryKeyAttribute => $this->getChildrenArray($parent)]);
        }

        /** @var TreeCategory[] $items */
        $items = $query->all();

        /** @var TreeCategory[][] $categories */
        $categories = [];
        foreach ($items as $item) {
            $categories[Attribute::intOrNull($item, $this->parentAttribute) ?: 0][] = $item;
        }

        return $this->getMenuListRecursive($path, $categories, $parent ?: 0, $sub);
    }

    public function findByPath(string $path): ?ActiveRecord
    {
        $chunks = explode('/', trim($path, '/'));
        /** @var ActiveRecord|null $model */
        $model = null;

        $query = $this->getQuery();

        if (\count($chunks) === 1) {
            $query
                ->andWhere([$this->slugAttribute => $chunks[0]])
                ->andWhere(['or', [$this->parentAttribute => null], [$this->parentAttribute => 0]]);
            $model = $query->limit(1)->one();
        } else {
            $query->andWhere([$this->slugAttribute => $chunks[0]]);
            /** @var TreeCategory|null $parent */
            $parent = $query->limit(1)->one();

            if ($parent !== null) {
                $chunks = \array_slice($chunks, 1);
                foreach ($chunks as $slug) {
                    /** @var TreeCategory|null $model */
                    $model = $parent->getChildBySlug($slug, $this->getQuery());
                    if ($model === null) {
                        return null;
                    }
                    $parent = $model;
                }
            }
        }

        /** @var ActiveRecord|null */
        return $model;
    }

    public function getChildrenArray(int $parent = null): array
    {
        /** @var ActiveRecord[] $items */
        $items = $this->getQuery()
            ->select([$this->primaryKeyAttribute, $this->titleAttribute, $this->parentAttribute])
            ->all();

        /** @var int[] $result */
        $result = [];

        $this->childrenArrayRecursive($items, $result, $parent);

        return array_unique($result);
    }

    /**
     * @param ActiveRecord[] $items
     * @param string[] $result
     */
    private function getTabListRecursive(array &$items, array &$result, ?int $parent, int $indent = 0): void
    {
        foreach ($items as $item) {
            if (
                Attribute::intOrNull($item, $this->parentAttribute) === $parent &&
                !isset($result[Attribute::int($item, $this->primaryKeyAttribute)])
            ) {
                $result[Attribute::int($item, $this->primaryKeyAttribute)] =
                    str_repeat('-- ', $indent) . Attribute::string($item, $this->titleAttribute);
                $this->getTabListRecursive(
                    $items,
                    $result,
                    Attribute::int($item, $this->primaryKeyAttribute),
                    $indent + 1
                );
            }
        }
    }

    /**
     * @param ActiveRecord[][] $items
     * @return array|string[]
     */
    private function getUrlListRecursive(array $items, int $parent, int $indent = 0): array
    {
        $resultArray = [];
        if (isset($items[$parent]) && $items[$parent]) {
            foreach ($items[$parent] as $item) {
                $resultArray += [
                    Attribute::string($item, $this->urlAttribute) => str_repeat('-- ', $indent) . Attribute::string($item, $this->titleAttribute),
                ] + $this->getUrlListRecursive($items, (int)$item->getPrimaryKey(), $indent + 1);
            }
        }
        return $resultArray;
    }

    /**
     * @param TreeCategory[][] $items
     * @return array[]
     */
    private function getMenuListRecursive(string $path, array $items, int $parent, int $sub): array
    {
        $resultArray = [];
        if (isset($items[$parent]) && $items[$parent]) {
            foreach ($items[$parent] as $item) {
                $id = (int)$item->getPrimaryKey();
                $resultArray[$id] = [
                    'id' => $id,
                    'label' => Attribute::string($item, $this->titleAttribute),
                    'url' => Attribute::string($item, $this->urlAttribute),
                    'icon' => $this->iconAttribute !== null ? Attribute::string($item, $this->iconAttribute) : '',
                    'active' => $item->isLinkActive($path),
                ] + (
                    $sub
                        ? ['items' => $this->getMenuListRecursive($path, $items, (int)$item->getPrimaryKey(), $sub - 1)]
                        : []
                );
            }
        }
        return $resultArray;
    }

    /**
     * @param ActiveRecord[] $items
     * @param int[] $result
     */
    private function childrenArrayRecursive(array &$items, array &$result, ?int $parent): void
    {
        foreach ($items as $item) {
            if (Attribute::intOrNull($item, $this->parentAttribute) === $parent) {
                $result[] = Attribute::int($item, $this->primaryKeyAttribute);
                $this->childrenArrayRecursive($items, $result, Attribute::int($item, $this->primaryKeyAttribute));
            }
        }
    }

    /**
     * @param string[] $attributes
     * @return ActiveRecord[]
     */
    private function getFullAssocData(array $attributes, int $parent = null): array
    {
        $query = $this->getQuery();

        $attributes = array_unique(array_merge($attributes, [$this->primaryKeyAttribute]));

        $query->select(array_combine($attributes, $attributes));

        if ($parent !== null) {
            $query->andWhere([$this->primaryKeyAttribute => array_merge([$parent], $this->getChildrenArray($parent))]);
        }

        /** @var ActiveRecord[] */
        return $query->all();
    }
}
