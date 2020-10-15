<?php

namespace app\components\category\behaviors;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class CategoryTreeBehavior extends CategoryBehavior
{
    public string $titleAttribute = 'title';
    public string $parentAttribute = 'parent_id';
    public string $parentRelation = 'parent';
    public string $urlAttribute = 'url';

    public function getPath(string $separator = '/'): string
    {
        $uri = [$this->getModel()->{$this->aliasAttribute}];

        $category = $this->getModel();

        $i = 10;

        while ($i-- && $category->{$this->parentRelation}) {
            $uri[] = $category->{$this->parentRelation}->{$this->aliasAttribute};
            $category = $category->{$this->parentRelation};
        }
        return implode($separator, array_reverse($uri));
    }

    public function getChildByAlias(string $alias, ActiveQuery $query = null): ?ActiveRecord
    {
        if ($query === null) {
            $query = $this->getModel()::find();
        }

        $query->andWhere([
            $this->aliasAttribute => $alias,
            $this->parentAttribute => $this->getModel()->getPrimaryKey()
        ]);

        return $query->limit(1)->one();
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

    public function getBreadcrumbs(bool $lastLink = false): array
    {
        if ($lastLink) {
            $breadcrumbs = [$this->getModel()->{$this->titleAttribute} => $this->getModel()->{$this->urlAttribute}];
        } else {
            $breadcrumbs = [$this->getModel()->{$this->titleAttribute}];
        }
        $page = $this->getModel();

        $i = 50;

        while ($i-- && $page->{$this->parentRelation}) {
            $breadcrumbs[$page->{$this->parentRelation}->{$this->titleAttribute}] = $page->{$this->parentRelation}->{$this->urlAttribute};
            $page = $page->{$this->parentRelation};
        }
        return array_reverse($breadcrumbs);
    }

    public function getFullTitle(bool $inverse = false, string $separator = ' - '): string
    {
        $titles = [$this->getModel()->{$this->titleAttribute}];

        $item = $this->getModel();
        $i = 50;
        while ($i-- && $item->{$this->parentRelation}) {
            $titles[] = $item->{$this->parentRelation}->{$this->titleAttribute};
            $item = $item->{$this->parentRelation};
        }
        return implode($separator, $inverse ? $titles : array_reverse($titles));
    }

    public function isLinkActive(string $path): bool
    {
        /** @var self $model */
        $model = $this->getModel();
        return mb_strpos($path, $model->getPath(), 0, 'UTF-8') === 0;
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
}
