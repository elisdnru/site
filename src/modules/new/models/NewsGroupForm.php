<?php

/**
 * This is the model class for table "{{new_group}}".
 *
 * The followings are the available columns in table '{{new_group}}':
 * @property integer $id
 * @property string $title
 */
class NewsGroupForm extends CFormModel
{
	public $title;

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title', 'required'),
			array('title', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Наименование группы',
		);
	}

}