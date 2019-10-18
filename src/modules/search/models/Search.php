<?php

namespace app\modules\search\models;

use app\modules\blog\models\Tag;
use CActiveRecord;

/**
 * @property string $title
 * @property string $text
 * @property string $material_class
 * @property integer $material_id
 */
class Search extends CActiveRecord
{
    /**
     * @param string|null $className
     * @return CActiveRecord|static
     */
    public static function model($className = null): self
    {
        return parent::model($className ?: static::class);
    }

    public function tableName(): string
    {
        return 'search';
    }

    private $_material;

    public function getMaterial()
    {
        if ($this->_material === null) {
            $this->_material = CActiveRecord::model($this->material_class)->findByPk($this->material_id);
        }

        return $this->_material;
    }
}
