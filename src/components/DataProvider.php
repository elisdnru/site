<?php

declare(strict_types=1);

namespace app\components;

use yii\data\DataProviderInterface;
use yii\data\Pagination;
use yii\data\Sort;

/**
 * @template T
 */
final class DataProvider
{
    private DataProviderInterface $origin;

    public function __construct(DataProviderInterface $origin)
    {
        $this->origin = $origin;
    }

    /**
     * @return T[]
     */
    public function getItems(): array
    {
        return $this->origin->getModels();
    }

    public function getCount(): int
    {
        return $this->origin->getCount();
    }

    public function getTotalCount(): int
    {
        return $this->origin->getTotalCount();
    }

    public function getSort(): Sort
    {
        return $this->origin->getSort() ?: new Sort();
    }

    public function getPagination(): Pagination
    {
        return $this->origin->getPagination() ?: new Pagination();
    }
}
