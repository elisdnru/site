<?php

declare(strict_types=1);

namespace app\components\category;

use yii\db\ActiveRecordInterface;

class Attribute
{
    public static function arOrNull(ActiveRecordInterface $model, string $attribute): ?ActiveRecordInterface
    {
        /** @var ActiveRecordInterface|null */
        return $model->{$attribute};
    }

    /**
     * @param ActiveRecordInterface $model
     * @param string $attribute
     * @return ActiveRecordInterface[]
     */
    public static function ars(ActiveRecordInterface $model, string $attribute): array
    {
        /** @var ActiveRecordInterface[] */
        return $model->{$attribute};
    }

    public static function string(ActiveRecordInterface $model, string $attribute): string
    {
        /** @var string */
        return $model->{$attribute};
    }

    public static function int(ActiveRecordInterface $model, string $attribute): int
    {
        /** @var int */
        return $model->{$attribute};
    }

    public static function intOrNull(ActiveRecordInterface $model, string $attribute): ?int
    {
        /** @var int|null */
        return $model->{$attribute};
    }
}
