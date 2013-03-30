<?php

/**
 * This is the model class for table "{{shop_attribute}}".
 *
 * The followings are the available columns in table '{{shop_attribute}}':
 * @property integer $id
 * @property integer $type_id
 * @property integer $sort
 * @property string $alias
 * @property string $title
 * @property integer $inshort
 *
 * @property ShopType $type
 * @property ShopProductAttributeValue[] $attribute_values
 */
class ShopProductAttribute extends CActiveRecord
{
    public $value;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ShopProductAttribute the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{shop_attribute}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('alias, title', 'required'),
			array('sort, inshort, type_id', 'numerical', 'integerOnly'=>true),
			array('alias, title', 'length', 'max'=>255),
            array('type_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, type_id, alias, title, inshort', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'type' => array(self::BELONGS_TO, 'ShopType', 'type_id'),
            'attribute_values' => array(self::HAS_MANY, 'ShopProductAttributeValue', 'attribute_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id'=>'ID',
			'type_id'=>'Тип товаров',
			'sort'=>'Позиция',
			'alias'=>'URL',
			'title'=>'Атрибут',
			'inshort'=>'Отображать в списке товаров',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.type_id',$this->type_id,true);
		$criteria->compare('t.sort',$this->sort,true);
		$criteria->compare('t.alias',$this->alias,true);
		$criteria->compare('t.title',$this->title,true);
		$criteria->compare('t.inshort',$this->inshort);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /** scope
     * @param $type_id
     * @return ShopProductAttribute
     */
    public function type($type_id)
    {
        if ($type_id)
        {
            $this->getDbCriteria()->mergeWith(array(
                'condition' => 't.type_id=:type OR t.type_id = 0',
                'params'=>array(':type'=>$type_id),
            ));
        }
        return $this;
    }

    protected function beforeDelete()
    {
        if (parent::beforeDelete())
        {
            foreach ($this->attribute_values as $value)
                $value->delete();

            return true;
        }

        return false;
    }
}