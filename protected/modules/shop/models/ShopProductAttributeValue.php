<?php

/**
 * This is the model class for table "{{shop_attribute_value}}".
 *
 * The followings are the available columns in table '{{shop_attribute_value}}':
 * @property integer $id
 * @property integer $product_id
 * @property integer $attribute_id
 * @property string $value
 *
 * @property ShopProduct $product
 * @property ShopProductAttribute $attribute
 */
class ShopProductAttributeValue extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ShopProductAttributeValue the static model class
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
		return '{{shop_attribute_value}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('product_id, attribute_id', 'required'),
			array('product_id, attribute_id', 'numerical', 'integerOnly'=>true),
			array('value', 'length', 'max'=>255),
			array('id, product_id, attribute_id, value', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
            'product'=>array(self::BELONGS_TO, 'ShopProduct', 'product_id'),
            'attribute'=>array(self::BELONGS_TO, 'ShopProductAttribute', 'attribute_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'product_id' => 'Product',
			'attribute_id' => 'Attribute',
			'value' => 'Value',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.product_id',$this->product_id);
		$criteria->compare('t.attribute_id',$this->attribute_id);
		$criteria->compare('t.value',$this->value,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}