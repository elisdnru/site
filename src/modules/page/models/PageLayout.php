<?php

/**
 * This is the model class for table "{{pagelayout}}".
 *
 * The followings are the available columns in table '{{pagelayout}}':
 * @property integer $id
 * @property string $alias
 * @property string $title
 */
class PageLayout extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return PageLayout the static model class
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
		return '{{page_layout}}';
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
			array('alias', 'length', 'max'=>128),
            array('alias', 'match', 'pattern' => '#^\w[a-zA-Z0-9_-]+$#', 'message' => 'Допустимы только латинские символы, цифры и знак подчёркивания'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, alias, title', 'safe', 'on'=>'search'),
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
			'title' => 'Заголовок',
            'alias' => 'Файл',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('alias',$this->alias,true);
		$criteria->compare('title',$this->title,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getAssocList()
    {
        $criteria = new CDbCriteria;
        $criteria->order = 'id ASC';
        $criteria->select = 'id, title';

        return CHtml::listData($this->findAll($criteria), 'id', 'title');
    }

    public function getAliasList()
    {
        $criteria = new CDbCriteria;
        $criteria->order = 'id ASC';
        $criteria->select = 'alias, title';

        return CHtml::listData($this->findAll($criteria), 'alias', 'title');
    }
}