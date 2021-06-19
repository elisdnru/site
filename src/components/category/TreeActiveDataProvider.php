<?php

declare(strict_types=1);

namespace app\components\category;

use LogicException;
use yii\base\InvalidConfigException;
use yii\data\ActiveDataProvider;
use yii\data\Sort;
use yii\db\ActiveQuery;
use yii\db\ActiveRecordInterface;
use yii\db\Connection;

class TreeActiveDataProvider extends ActiveDataProvider
{
    public string $childrenRelation = 'children';

    protected function prepareModels(): array
    {
        $originQuery = $this->query;

        if (!$originQuery instanceof ActiveQuery) {
            throw new InvalidConfigException(
                'The "query" property must be an instance of a class that implements the ActiveQuery.'
            );
        }

        $query = clone $originQuery;
        if (($pagination = $this->getPagination()) !== false) {
            $pagination->totalCount = $this->getTotalCount();
            if ($pagination->totalCount === 0) {
                return [];
            }
            $query->limit($pagination->getLimit())->offset($pagination->getOffset());
        }
        if (($sort = $this->getSort()) instanceof Sort) {
            $query->addOrderBy($sort->getOrders());
        }

        $rootQuery = clone $query;
        $isEmptyCondition = empty($rootQuery->where);

        if ($isEmptyCondition) {
            $rootQuery->andWhere(['parent_id' => null]);
        }

        if ($this->db !== null && !$this->db instanceof Connection) {
            throw new LogicException('Type');
        }

        $items = $rootQuery->all($this->db);

        if ($isEmptyCondition) {
            $items = $this->buildRecursive($items);
        }

        return $items;
    }

    /**
     * @param ActiveRecordInterface[] $items
     * @return ActiveRecordInterface[]
     */
    protected function buildRecursive(array $items, int $indent = 0, int $foolproof = 20): array
    {
        $data = [];
        foreach ($items as $item) {
            /** @psalm-suppress NoInterfaceProperties */
            $item->indent = $indent;
            $data[] = $item;
            if ($foolproof && $children = Attribute::ars($item, $this->childrenRelation)) {
                /** @noinspection SlowArrayOperationsInLoopInspection */
                $data = array_merge(
                    $data,
                    $this->buildRecursive($children, $indent + 1, $foolproof - 1)
                );
            }
        }
        return $data;
    }
}
