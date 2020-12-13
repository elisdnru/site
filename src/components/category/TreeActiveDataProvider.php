<?php

namespace app\components\category;

use yii\base\InvalidConfigException;
use yii\data\ActiveDataProvider;
use yii\db\QueryInterface;

class TreeActiveDataProvider extends ActiveDataProvider
{
    public string $childrenRelation = 'children';

    protected function prepareModels(): array
    {
        if (!$this->query instanceof QueryInterface) {
            throw new InvalidConfigException('The "query" property must be an instance of a class that implements the QueryInterface e.g. yii\db\Query or its subclasses.');
        }
        $query = clone $this->query;
        if (($pagination = $this->getPagination()) !== false) {
            $pagination->totalCount = $this->getTotalCount();
            if ($pagination->totalCount === 0) {
                return [];
            }
            $query->limit($pagination->getLimit())->offset($pagination->getOffset());
        }
        if (($sort = $this->getSort()) !== false) {
            $query->addOrderBy($sort->getOrders());
        }

        $rootQuery = clone $query;
        $isEmptyCondition = empty($rootQuery->where);

        if ($isEmptyCondition) {
            $rootQuery->andWhere(['parent_id' => null]);
        }

        $items = $rootQuery->all($this->db);

        if ($isEmptyCondition) {
            $items = $this->buildRecursive($items);
        }

        return $items;
    }

    protected function buildRecursive(array $items, int $indent = 0, int $foolproof = 20): array
    {
        $data = [];
        foreach ($items as $item) {
            $item->indent = $indent;
            $data[] = $item;
            if ($foolproof && $item->{$this->childrenRelation}) {
                /** @noinspection SlowArrayOperationsInLoopInspection */
                $data = array_merge(
                    $data,
                    $this->buildRecursive($item->{$this->childrenRelation}, $indent + 1, $foolproof - 1)
                );
            }
        }
        return $data;
    }
}
