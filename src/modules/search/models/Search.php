<?php

namespace app\modules\search\models;

use yii\db\ActiveRecord;

/**
 * @property string $title
 * @property string $text
 * @property string $material_class
 * @property integer $material_id
 *
 * @property ActiveRecord $material
 */
class Search extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'search';
    }

    private ?ActiveRecord $cachedMaterial = null;

    public function getMaterial(): ?ActiveRecord
    {
        if ($this->cachedMaterial === null) {
            /** @var ActiveRecord $class */
            $class = $this->material_class;
            $this->cachedMaterial = $class::findOne($this->material_id);
        }

        return $this->cachedMaterial;
    }
}
