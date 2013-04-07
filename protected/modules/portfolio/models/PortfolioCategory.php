<?php

DUrlRulesHelper::import('portfolio');
Yii::import('application.modules.category.models.*');

/**
 * This is the model class for table "{{portfolio_category}}".
 */

class PortfolioCategory extends TreeCategory
{
    public $urlRoute = '/portfolio/default/category';
    public $multiLanguage = true;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BlogCategory the static model class
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
		return '{{portfolio_category}}';
	}

    public function rules()
    {
        return array_merge(parent::rules(), array(
            array('parent_id', 'DExistOrEmpty', 'className' => 'PortfolioCategory', 'attributeName' => 'id'),
        ));
    }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array_merge(parent::relations(), array(
            'parent' => array(self::BELONGS_TO, 'PortfolioCategory', 'parent_id'),
            'child_items' => array(self::HAS_MANY, 'PortfolioCategory', 'parent_id',
                'order'=>'child_items.sort ASC'
            ),
            'items_count' => array(self::STAT, 'PortfolioWork', 'category_id',
                'condition'=>'public = 1',
            ),
		));
	}
}