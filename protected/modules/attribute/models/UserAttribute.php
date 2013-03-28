<?php

/**
 * This is the model class for table "{{user_attribute}}".
 *
 * The followings are the available columns in table '{{user_attribute}}':
 * @property integer $id
 * @property integer $sort
 * @property string $class
 * @property string $name
 * @property string $label
 * @property string $type
 * @property string $rule
 * @property string $required
 */
class UserAttribute extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserAttribute the static model class
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
		return '{{attribute}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, label, type, class, rule', 'required'),
			array('sort, required', 'numerical', 'integerOnly'=>true),
			array('name, label, type, class', 'length', 'max'=>255),
            array('name','match','pattern' => '#^[a-zA-Z][a-zA-Z0-9_]+$#', 'message' => 'Только латинские символы, цифры и знак подчёркивания'),
			array('id, sort, name, label, type, class, rule', 'safe', 'on'=>'search'),
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
            'values'=>array(self::HAS_MANY, 'UserAttributeValue', 'attribute_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'class' => 'Сущность',
			'sort' => 'Позиция',
			'name' => 'Атрибут',
			'label' => 'Наименование',
			'type' => 'Тип поля',
			'rule' => 'Содержимое',
			'required' => 'Обязательный',
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
		$criteria->compare('class',$this->class,true);
		$criteria->compare('sort',$this->sort);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('label',$this->label,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('rule',$this->rule);
		$criteria->compare('required',$this->required);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    protected function afterDelete()
    {
        foreach ($this->values as $value)
            $value->delete();

        parent::afterDelete();
    }

    public static function getTypes()
    {
        return array(
            'string'=>'Строка',
            'text'=>'Текст',
        );
    }

    public static function getTypeName($name)
    {
        $types = self::getTypes();
        return isset($types[$name]) ? $types[$name] : $name;
    }

    public static function getRules()
    {
        return array(
            'safe'=>'Любое содержимое',
            '|^[\d-]+$|'=>'Цифры и тире',
            'site'=>'Сайт',
            'email'=>'Email',
        );
    }

    public static function getRuleName($name)
    {
        $rules = self::getRules();
        return isset($rules[$name]) ? $rules[$name] : $name;
    }
}