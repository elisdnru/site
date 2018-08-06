<?php

/**
 * This is the model class for table "{{config}}".
 *
 * The followings are the available columns in table '{{config}}':
 * @property string $id
 * @property string $param
 * @property string $value
 * @property string $label
 * @property string $type
 * @property string $default
 * @property string $variants
 */
class Config extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return Config the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{config}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            ['param, label', 'required'],
            ['param, type', 'length', 'max' => 128],
            ['value', 'safe'],
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            ['id, param, value, label, type, default, variants', 'safe', 'on' => 'search'],
        ];
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return [];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'param' => 'Параметр',
            'value' => 'Значение',
            'label' => 'Название',
            'type' => 'Тип',
            'default' => 'По умолчанию',
            'variants' => 'Варианты',
        ];
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('param', $this->param, true);
        $criteria->compare('value', $this->value, true);
        $criteria->compare('label', $this->label, true);
        $criteria->compare('type', $this->type, true);
        $criteria->compare('default', $this->default, true);
        $criteria->compare('variants', $this->variants, true);

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
        ]);
    }
}
