<?php

namespace app\components\category\behaviors;

use CActiveRecord;
use CDbCriteria;
use CException;
use Yii;

/**
 * @property integer[] $childrenArray
 * @property mixed $tabList
 * @property string $path
 * @property string $breadcrumbs
 */
class CategoryTreeBehavior extends CategoryBehavior
{
    /**
     * @var string model attribute
     */
    public $parentAttribute = 'parent_id';
    /**
     * @var string model parent BELONGS_TO relation
     */
    public $parentRelation = 'parent';

    /**
     * Returns array of primary keys of children items
     * @param mixed $parent number, object or array of numbers
     * @return array
     * @throws CException
     */
    public function getChildrenArray($parent = 0): array
    {
        $parents = $this->processParents($parent);

        $this->cached();

        $criteria = $this->getOwnerCriteria();
        $criteria->select = 't.' . $this->getPrimaryKeyAttribute() . ', t.' . $this->titleAttribute . ', t.' . $this->parentAttribute;
        $command = $this->createFindCommand($criteria);
        $items = $command->queryAll();
        $this->clearOwnerCriteria();

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
                $result[] = $item[$this->getPrimaryKeyAttribute()];
                $this->childrenArrayRecursive($items, $result, $item[$this->getPrimaryKeyAttribute()]);
            }
        }
    }

    /**
     * Returns associated array ($id=>$fullTitle, $id=>$fullTitle, ...)
     * @param mixed $parent number, object or array of numbers
     * @return array
     */
    public function getAssocList($parent = 0): array
    {
        $this->cached();

        $items = $this->getFullAssocData([
            $this->getPrimaryKeyAttribute(),
            $this->titleAttribute,
            $this->parentAttribute,
        ], $parent);

        $associated = [];
        foreach ($items as $item) {
            $associated[$item[$this->getPrimaryKeyAttribute()]] = $item;
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

            $result[$item[$this->getPrimaryKeyAttribute()]] = implode(' - ', array_reverse($titles));
        }

        return $result;
    }

    /**
     * Returns associated array ($alias=>$fullTitle, $alias=>$fullTitle, ...)
     * @param mixed $parent number, object or array of numbers
     * @return array
     */
    public function getAliasList($parent = 0): array
    {
        $this->cached();

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

    /**
     * Returns tabulated array ($id=>$title, $id=>$title, ...)
     * @param mixed $parent number, object or array of numbers
     * @return array
     */
    public function getTabList($parent = 0): array
    {
        $parents = $this->processParents($parent);

        $this->cached();

        $items = $this->getFullAssocData([
            $this->getPrimaryKeyAttribute(),
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
            if ((int)$item[$this->parentAttribute] === (int)$parent_id && !isset($result[$item[$this->getPrimaryKeyAttribute()]])) {
                $result[$item[$this->getPrimaryKeyAttribute()]] = str_repeat('-- ', $indent) . $item[$this->titleAttribute];
                $this->getTabListRecursive($items, $result, $item[$this->getPrimaryKeyAttribute()], $indent + 1);
            }
        }
    }

    /**
     * Returns tabulated array ($url=>$title, $url=>$title, ...)
     * @param mixed $parent number, object or array of numbers
     * @return array
     * @throws CException
     */
    public function getUrlList($parent = 0): array
    {
        $criteria = $this->getOwnerCriteria();

        if (!$parent) {
            $parent = $this->getModel()->getPrimaryKey();
        }

        if ($parent) {
            $criteria->compare($this->getPrimaryKeyAttribute(), $this->getChildrenArray($parent));
        }

        $items = $this->cached($this->getModel())->findAll($criteria);

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

    /**
     * Returns items for Menu widget
     * @param int $sub levels
     * @param mixed $parent number, object or array of numbers
     * @return array
     * @throws CException
     */
    public function getMenuList(int $sub = 0, $parent = 0): array
    {
        $criteria = $this->getOwnerCriteria();

        if (!$parent) {
            $parent = $this->getModel()->getPrimaryKey();
        }

        if ($parent) {
            $criteria->compare($this->getPrimaryKeyAttribute(), $this->getChildrenArray($parent));
        }

        $items = $this->cached($this->getModel())->findAll($criteria);

        $categories = [];
        foreach ($items as $item) {
            $categories[(int)$item->{$this->parentAttribute}][] = $item;
        }

        return $this->getMenuListRecursive($categories, $parent, $sub);
    }

    protected function getMenuListRecursive(array $items, $parent, $sub): array
    {
        $parent = (int)$parent;
        $resultArray = [];
        if (isset($items[$parent]) && $items[$parent]) {
            foreach ($items[$parent] as $item) {
                $active = $item->{$this->linkActiveAttribute};
                $id = $item->getPrimaryKey();
                $resultArray[$id] = [
                        'id' => $id,
                        'label' => $item->{$this->titleAttribute},
                        'url' => $item->{$this->urlAttribute},
                        'icon' => $this->iconAttribute !== null ? $item->{$this->iconAttribute} : '',
                        'active' => $active,
                        'itemOptions' => ['class' => 'item_' . $item->getPrimaryKey()],
                        'linkOptions' => $active ? ['rel' => 'nofollow'] : [],
                    ] + ($sub ? ['items' => $this->getMenuListRecursive($items, $item->getPrimaryKey(), $sub - 1)] : []);
            }
        }
        return $resultArray;
    }

    public function findByPath(string $path): ?CActiveRecord
    {
        $domens = explode('/', trim($path, '/'));
        $model = null;

        $criteria = $this->getOwnerCriteria();

        if (count($domens) === 1) {
            $criteria->mergeWith([
                'condition' => 't.' . $this->aliasAttribute . '=:alias AND (t.' . $this->parentAttribute . ' iS NULL OR t.' . $this->parentAttribute . '=0)',
                'params' => [':alias' => $domens[0]]
            ]);
            $model = $this->cached($this->getModel())->find($criteria);
        } else {
            $criteria->mergeWith([
                'condition' => 't.' . $this->aliasAttribute . '=:alias',
                'params' => [':alias' => $domens[0]]
            ]);
            /** @var CActiveRecord|self $parent */
            $parent = $this->cached($this->getModel())->find($criteria);

            if ($parent) {
                $domens = array_slice($domens, 1);
                foreach ($domens as $alias) {
                    $model = $parent->getChildByAlias($alias, $this->getOriginalCriteria());
                    if (!$model) {
                        return null;
                    }
                    $parent = $model;
                }
            }
        }
        return $model;
    }

    public function isChildOf($parent): bool
    {
        $model = $this->getModel();

        if (is_int($parent) && $model->getPrimaryKey() === $parent) {
            return false;
        }

        $parents = $this->arrayFromArgs($parent);

        $i = 50;

        while ($i-- && $model) {
            if (in_array($model->getPrimaryKey(), $parents, true)) {
                return true;
            }
            $model = $model->{$this->parentRelation};
        }
        return false;
    }

    public function getPath(string $separator = '/'): string
    {
        $uri = [$this->getModel()->{$this->aliasAttribute}];

        $category = $this->getModel();

        $i = 10;

        while ($i-- && $this->cached($category)->{$this->parentRelation}) {
            $uri[] = $category->{$this->parentRelation}->{$this->aliasAttribute};
            $category = $category->{$this->parentRelation};
        }
        return implode(array_reverse($uri), $separator);
    }

    /**
     * Constructs breadcrumbs for zii.widgets.CBreadcrumbs widget
     * @param bool $lastLink if you can have link in last element
     * @return array
     */
    public function getBreadcrumbs(bool $lastLink = false): array
    {
        if ($lastLink) {
            $breadcrumbs = [$this->getModel()->{$this->titleAttribute} => $this->getModel()->{$this->urlAttribute}];
        } else {
            $breadcrumbs = [$this->getModel()->{$this->titleAttribute}];
        }
        $page = $this->getModel();

        $i = 50;

        while ($i-- && $this->cached($page)->{$this->parentRelation}) {
            $breadcrumbs[$page->{$this->parentRelation}->{$this->titleAttribute}] = $page->{$this->parentRelation}->{$this->urlAttribute};
            $page = $page->{$this->parentRelation};
        }
        return array_reverse($breadcrumbs);
    }

    /**
     * Constructs full title for current model
     * @param bool $inverse
     * @param string $separator
     * @return string
     */
    public function getFullTitle(bool $inverse = false, string $separator = ' - '): string
    {
        $titles = [$this->getModel()->{$this->titleAttribute}];

        $item = $this->getModel();
        $i = 50;
        while ($i-- && $this->cached($item)->{$this->parentRelation}) {
            $titles[] = $item->{$this->parentRelation}->{$this->titleAttribute};
            $item = $item->{$this->parentRelation};
        }
        return implode($inverse ? $titles : array_reverse($titles), $separator);
    }

    /**
     * Optional redeclare this method in your model for use (@link getMenuList())
     * or define in requestPathAttribute your $_GET attribute for url matching
     * @return bool true if current request url matches with category path
     */
    public function getLinkActive(): bool
    {
        return mb_strpos(Yii::$app->request->get($this->requestPathAttribute), $this->getModel()->getPath(), null, 'UTF-8') === 0;
    }

    protected function getFullAssocData(array $attributes, $parent = 0): array
    {
        $criteria = $this->getOwnerCriteria();

        $attributes = $this->aliasAttributes(array_unique(array_merge($attributes, [$this->getPrimaryKeyAttribute()])));

        $criteria->select = implode(', ', $attributes);

        if (!$parent) {
            $parent = $this->getModel()->getPrimaryKey();
        }

        if ($parent) {
            $criteria->compare($this->getPrimaryKeyAttribute(), array_merge([$parent], $this->getChildrenArray($parent)));
        }

        $command = $this->createFindCommand($criteria);
        $this->clearOwnerCriteria();

        return $command->queryAll();
    }

    protected function processParents($parent): array
    {
        if (!$parent) {
            $parent = $this->getModel()->getPrimaryKey();
        }
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

    protected function getChildByAlias(string $alias, CDbCriteria $criteria = null): ?CActiveRecord
    {
        if ($criteria === null) {
            $criteria = $this->getOwnerCriteria();
        }

        $criteria->mergeWith([
            'condition' => 't.' . $this->aliasAttribute . '=:alias AND t.' . $this->parentAttribute . '=:parent_id',
            'params' => [
                ':alias' => $alias,
                ':parent_id' => $this->getModel()->getPrimaryKey()
            ]
        ]);

        return $this->cached($this->getModel())->find($criteria);
    }

    /**
     * @return CActiveRecord|self
     */
    private function getModel(): CActiveRecord
    {
        /** @var CActiveRecord $owner */
        $owner = $this->getOwner();
        return $owner;
    }
}
