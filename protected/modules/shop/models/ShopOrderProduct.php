<?php

/**
 * This is the model class for table "{{shop_order_id_product_id}}".
 *
 * The followings are the available columns in table '{{shop_order_id_product_id}}':
 * @property integer $id
 * @property integer $order_id
 * @property integer $product_id
 * @property string $artikul
 * @property string $title
 * @property double $price
 * @property integer $count
 * @property string $comment
 */
class ShopOrderProduct extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ShopOrderProduct the static model class
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
		return '{{shop_order_product}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('order_id, product_id, count', 'required'),
			array('order_id, product_id, count', 'numerical', 'integerOnly'=>true),
			array('price', 'numerical'),
			array('artikul, title, price, comment', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, order_id, product_id, artikul, title, comment, price, count', 'safe', 'on'=>'search'),
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
            'order' => array(self::BELONGS_TO, 'ShopOrder', 'order_id'),
            'product' => array(self::BELONGS_TO, 'ShopProduct', 'product_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'order_id' => 'Заказ',
			'product_id' => 'Продукт',
			'artikul' => 'Артикул',
			'title' => 'Заголовок',
			'price' => 'Цена',
			'count' => 'Количество',
			'comment' => 'Комментарий',
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
		$criteria->compare('t.order_id',$this->order_id);
		$criteria->compare('t.product_id',$this->product_id);
		$criteria->compare('t.artikul',$this->artikul,true);
		$criteria->compare('t.title',$this->title,true);
		$criteria->compare('t.price',$this->price);
		$criteria->compare('t.count',$this->count);
		$criteria->compare('t.comment',$this->comment);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    protected function beforeValidate()
    {
        if ($product = ShopProduct::model()->findByPk($this->product_id))
        {
            $this->artikul = $product->artikul;
            $this->title = $product->title;
            $this->price = $product->price;
        }

        return parent::beforeValidate();
    }
}