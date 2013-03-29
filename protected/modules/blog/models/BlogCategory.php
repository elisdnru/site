<?php

DUrlRulesHelper::import('blog');
Yii::import('application.modules.category.models.*');

/**
 * This is the model class for table "{{blog_category}}".
 *
 * @method BlogCategory multilang();
 */

class BlogCategory extends TreeCategory
{
    public $urlRoute = '/blog/default/category';
    public $multiLanguage = true;
    public $indent = 0;

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
		return '{{blog_category}}';
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array_merge(parent::relations(), array(
            'parent' => array(self::BELONGS_TO, 'BlogCategory', 'parent_id'),
            'posts_count' => array(self::STAT, 'BlogPost', 'category_id'),
            'posts' => array(self::HAS_MANY, 'BlogPost', 'category_id'),
            'childs' => array(self::HAS_MANY, 'BlogCategory', 'parent_id',
                'order'=>'childs.sort ASC'
            ),
            'items_count' => array(self::STAT, 'BlogPost', 'category_id',
                'condition'=>'public = 1',
            ),
		));
	}
}