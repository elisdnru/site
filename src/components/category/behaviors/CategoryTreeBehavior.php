<?php

declare(strict_types=1);

namespace app\components\category\behaviors;

use app\components\category\Attribute;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

final class CategoryTreeBehavior extends CategoryBehavior
{
    public string $titleAttribute = 'title';
    public string $parentAttribute = 'parent_id';
    public string $parentRelation = 'parent';
    public string $urlAttribute = 'url';

    public function getPath(string $separator = '/'): string
    {
        $uri = [Attribute::string($this->getModel(), $this->slugAttribute)];

        $category = $this->getModel();

        $i = 10;

        while ($i-- && $parent = Attribute::arOrNull($category, $this->parentRelation)) {
            $uri[] = Attribute::string($parent, $this->slugAttribute);
            $category = $parent;
        }
        return implode($separator, array_reverse($uri));
    }

    public function getChildBySlug(string $slug, ?ActiveQuery $query = null): ?ActiveRecord
    {
        if ($query === null) {
            $query = $this->getModel()::find();
        }

        $query->andWhere([
            $this->slugAttribute => $slug,
            $this->parentAttribute => (int)$this->getModel()->getPrimaryKey(),
        ]);

        /** @var ActiveRecord|null */
        return $query->limit(1)->one();
    }

    public function isChildOf(int $parent): bool
    {
        $model = $this->getModel();

        $i = 50;

        while ($i-- && $model) {
            if ((int)$model->getPrimaryKey() === $parent) {
                return true;
            }
            $model = Attribute::arOrNull($model, $this->parentRelation);
        }

        return false;
    }

    /**
     * @return string[]
     */
    public function getBreadcrumbs(bool $lastLink = false): array
    {
        if ($lastLink) {
            $breadcrumbs = [
                Attribute::string($this->getModel(), $this->titleAttribute) => Attribute::string($this->getModel(), $this->urlAttribute),
            ];
        } else {
            $breadcrumbs = [Attribute::string($this->getModel(), $this->titleAttribute)];
        }
        $page = $this->getModel();

        $i = 50;

        while ($i-- && $parent = Attribute::arOrNull($page, $this->parentRelation)) {
            $breadcrumbs[Attribute::string($parent, $this->titleAttribute)] =
                Attribute::string($parent, $this->urlAttribute);
            $page = $parent;
        }
        return array_reverse($breadcrumbs);
    }

    public function getFullTitle(bool $inverse = false, string $separator = ' - '): string
    {
        $titles = [Attribute::string($this->getModel(), $this->titleAttribute)];

        $item = $this->getModel();
        $i = 50;
        while ($i-- && $parent = Attribute::arOrNull($item, $this->parentRelation)) {
            $titles[] = Attribute::string($parent, $this->titleAttribute);
            $item = $parent;
        }
        return implode($separator, $inverse ? $titles : array_reverse($titles));
    }

    public function isLinkActive(string $path): bool
    {
        /** @var self $model */
        $model = $this->getModel();
        return mb_strpos($path, $model->getPath(), 0, 'UTF-8') === 0;
    }
}
