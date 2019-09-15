<?php

namespace app\modules\search\models;

use CActiveRecord;
use Yii;

/**
 * @property string $title
 * @property string $text
 * @property string $material_class
 * @property integer $material_id
 */
class Search extends CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return '{{search}}';
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
