<?php

Yii::import('category.models.*');

/**
 * This is the model class for table "{{shop_size}}".
 *
 * The followings are the available columns in table '{{shop_size}}':
 * @property string $type
 */
class ShopColour extends Category
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ShopColour the static model class
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
        return '{{shop_colour}}';
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
            'colour_values' => array(self::HAS_MANY, 'ShopProductColour', 'colour_id'),
        ));
    }

    public function behaviors()
    {
        return array(
            'CategoryBehavior'=>array(
                'class'=>'category.components.DCategoryBehavior',
                'titleAttribute'=>'title',
                'aliasAttribute'=>'alias',
                'iconAttribute'=>'imageUrl',
                'linkActiveAttribute'=>'linkActive',
                'requestPathAttribute'=>'type',
                'defaultCriteria'=>array(
                    'order'=>'t.sort ASC, t.title ASC'
                ),
            ),
        );
    }

    protected function beforeDelete()
    {
        if (parent::beforeDelete())
        {
            foreach ($this->colour_values as $value)
                $value->delete();

            return true;
        }

        return false;
    }

    private $_url;

    public function getUrl()
    {
        if ($this->_url === null)
            $this->_url = Yii::app()->controller->createUrl('', array_replace($_GET, array('colour'=>$this->title)));
        return $this->_url;
    }
}