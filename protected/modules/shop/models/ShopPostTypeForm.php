<?php

/**
 * This is the model class for table "{{shop_post}}".
 *
 * The followings are the available columns in table '{{shop_post}}':
 * @property integer $id
 * @property string $title
 * @property double $summ
 */
class ShopPostTypeForm extends CFormModel
{
    public $sort;
    public $title;
    public $summ;

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return ShopPostType::model()->rules();
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return ShopPostType::model()->attributeLabels();
	}
}