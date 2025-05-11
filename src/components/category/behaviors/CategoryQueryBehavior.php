<?php

declare(strict_types=1);

namespace app\components\category\behaviors;

use app\components\category\Attribute;
use app\components\category\models\Category;
use yii\base\Behavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class CategoryQueryBehavior extends Behavior
{
    public string $primaryKeyAttribute = 'id';
    public string $titleAttribute = 'title';
    public string $slugAttribute = 'slug';
    public string $urlAttribute = 'url';
    public ?string $iconAttribute = null;
    public array $defaultOrder = [];

    public function getArray(): array
    {
        return $this->getQuery()
            ->select([$this->primaryKeyAttribute])
            ->column();
    }

    public function getAssocList(): array
    {
        return $this->getQuery()
            ->select([$this->titleAttribute, $this->primaryKeyAttribute])
            ->indexBy($this->primaryKeyAttribute)
            ->column();
    }

    public function getSlugList(): array
    {
        /**
         * @psalm-suppress PossiblyInvalidMethodCall
         */
        $rows = $this->getQuery()
            ->select([$this->titleAttribute, $this->slugAttribute, $this->primaryKeyAttribute])
            ->indexBy($this->primaryKeyAttribute)
            ->asArray()
            ->all();

        return array_column($rows, $this->titleAttribute, $this->slugAttribute);
    }

    public function getUrlList(): array
    {
        /**
         * @var Category[] $items
         */
        $items = $this->getQuery()->indexBy($this->slugAttribute)->all();

        $result = [];
        foreach ($items as $item) {
            $result[Attribute::string($item, $this->urlAttribute)] = Attribute::string($item, $this->titleAttribute);
        }
        return $result;
    }

    public function getMenuList(string $path): array
    {
        /**
         * @var Category[] $items
         */
        $items = $this->getQuery()->indexBy($this->slugAttribute)->all();

        $result = [];
        foreach ($items as $item) {
            $id = (int)$item->getPrimaryKey();
            $result[$id] = [
                $this->primaryKeyAttribute => $id,
                'label' => Attribute::string($item, $this->titleAttribute),
                'url' => Attribute::string($item, $this->urlAttribute),
                'icon' => $this->iconAttribute !== null ? Attribute::string($item, $this->iconAttribute) : '',
                'active' => $item->isLinkActive($path),
            ];
        }
        return $result;
    }

    public function findBySlug(string $slug): ?ActiveRecord
    {
        /** @var ActiveRecord|null */
        return $this->getQuery()->andWhere([$this->slugAttribute => $slug])->limit(1)->one();
    }

    protected function getQuery(): ActiveQuery
    {
        /** @var ActiveQuery $owner */
        $owner = $this->owner;
        $query = clone $owner;
        return $query->cache()->orderBy($this->defaultOrder);
    }
}
