<?php

Yii::import('application.modules.category.models.*');

/**
 * This is the model class for table "{{shop_size}}".
 *
 * The followings are the available columns in table '{{shop_size}}':
 */
class ShopSize extends Category
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ShopSize the static model class
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
		return '{{shop_size}}';
	}

    public function rules()
    {
        return array_merge(parent::rules(), array(
            array('alias', 'unique', 'caseSensitive' => false, 'className'=>'ShopType', 'message' => 'Элемент с таким URL уже существует'),
        ));
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array_merge(parent::relations(), array(
            'size_values' => array(self::HAS_MANY, 'ShopProductSize', 'size_id'),
        ));
    }

    protected function beforeDelete()
    {
        if (parent::beforeDelete())
        {
            foreach ($this->size_values as $value)
                $value->delete();

            return true;
        }

        return false;
    }

    private $_url;

    public function getUrl()
    {
        if ($this->_url === null)
            $this->_url = Yii::app()->controller->createUrl('', array_replace($_GET, array('size'=>$this->title)));
        return $this->_url;
    }
}