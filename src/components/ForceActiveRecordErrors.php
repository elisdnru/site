<?php

declare(strict_types=1);

namespace app\components;

use Exception;
use RuntimeException;
use yii\db\StaleObjectException;

trait ForceActiveRecordErrors
{
    /**
     * @param bool $runValidation
     * @param array|null $attributes
     * @throws Exception
     * @return bool
     */
    public function insert($runValidation = true, $attributes = null)
    {
        $result = parent::insert($runValidation, $attributes);
        if ($result === false) {
            throw new RuntimeException('Unable to insert.');
        }
        return $result;
    }

    /**
     * @param bool $runValidation
     * @param array|null $attributeNames
     * @throws StaleObjectException
     * @return false|int
     */
    public function update($runValidation = true, $attributeNames = null)
    {
        $result = parent::update($runValidation, $attributeNames);
        if ($result === false) {
            throw new RuntimeException('Unable to update.');
        }
        return $result;
    }

    /**
     * @throws StaleObjectException
     * @return false|int
     */
    public function delete()
    {
        $result = parent::delete();
        if ($result === false) {
            throw new RuntimeException('Unable to delete.');
        }
        return $result;
    }
}
