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

    private $cachedMaterial;

    public function getMaterial()
    {
        if ($this->cachedMaterial === null) {
            $class = $this->material_class;
            if (is_subclass_of($class, ActiveRecord::class)) {
                /** @var ActiveRecord $class */
                $this->cachedMaterial = $class::findOne($this->material_id);
            } else {
                $this->cachedMaterial = CActiveRecord::model($this->material_class)->findByPk($this->material_id);
            }
        }

        return $this->cachedMaterial;
    }
}
