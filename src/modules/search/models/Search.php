<?php

namespace app\modules\search\models;

use CActiveRecord;
use yii\db\ActiveRecord;

/**
 * @property string $title
 * @property string $text
 * @property string $material_class
 * @property integer $material_id
 */
class Search extends ActiveRecord
{
    public static function tableName(): string
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
