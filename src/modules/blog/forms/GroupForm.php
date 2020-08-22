<?php

namespace app\modules\blog\forms;

use yii\base\Model;

/**
 * @property integer $id
 * @property string $title
 */
class GroupForm extends Model
{
    public ?string $title = null;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules(): array
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            ['title', 'required'],
            ['title', 'string', 'max' => 255],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Наименование группы',
        ];
    }
}
