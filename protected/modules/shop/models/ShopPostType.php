<?php

/**
 * This is the model class for table "{{shop_post}}".
 *
 * The followings are the available columns in table '{{shop_post}}':
 * @property integer $id
 * @property integer $sort
 * @property string $title
 * @property double $summ
 */
class ShopPostType extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ShopPostType the static model class
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
		return '{{shop_post_type}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title', 'required'),
			array('sort', 'numerical', 'integerOnly'=>true),
			array('summ', 'numerical'),
			array('title', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, summ', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'sort' => 'Порядок',
			'title' => 'Наименование',
			'summ' => 'Стоимость',
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
		$criteria->compare('t.sort',$this->sort);
		$criteria->compare('t.title',$this->title,true);
		$criteria->compare('t.summ',$this->summ);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getAssocList()
    {
        $items = $this->findAll(array(
            'order'=>'t.sort ASC',
        ));

        $result = array();

        foreach ($items as $item)
            $result[$item->id] = $item->title . ' [' . $item->summ . ' р]';

        return $result;
    }
}