<?php

DUrlRulesHelper::import('blog');
Yii::import('application.modules.category.models.*');

/**
 * This is the model class for table "{{blog_category}}".
 */

class BlogCategory extends Category
{
    public $urlRoute = '/blog/default/category';
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

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return DTreeActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($pageSize=10)
    {
        $criteria=new CDbCriteria;

        $criteria->compare('t.id',$this->id);
        $criteria->compare('t.alias',$this->alias,true);
        $criteria->compare('t.title',$this->title,true);
        $criteria->compare('t.text',$this->text,true);
        $criteria->compare('t.pagetitle',$this->pagetitle,true);
        $criteria->compare('t.description',$this->description,true);
        $criteria->compare('t.keywords',$this->keywords,true);
        $criteria->compare('t.parent_id',$this->parent_id);

        return new DTreeActiveDataProvider($this, array(
            'criteria'=>DMultilangHelper::enabled() ? $this->ml->modifySearchCriteria($criteria) : $criteria,
            'childRelation'=>'childs',
            'sort'=>array(
                'defaultOrder'=>'t.sort ASC, t.title ASC',
            ),
            'pagination'=>array(
                'pageSize'=>$pageSize,
                'pageVar'=>'page',
            ),
        ));
    }

    public function behaviors()
    {
        $behaviors = array(
            'CategoryBehavior'=>array(
                'class'=>'category.components.DCategoryTreeBehavior',
                'titleAttribute'=>'title',
                'aliasAttribute'=>'alias',
                'parentAttribute'=>'parent_id',
                'requestPathAttribute'=>'category',
                'parentRelation'=>'parent',
                'defaultCriteria'=>array(
                    'with'=>'i18nBlogCategory',
                    'order'=>'t.sort ASC, t.title ASC'
                ),
            ),
        );

        if (DMultilangHelper::enabled())
        {
            $behaviors = array_merge($behaviors, array(
                'ml' => array(
                    'class' => 'ext.multilangual.MultilingualBehavior',
                    'localizedAttributes' => array(
                        'title',
                        'text',
                        'pagetitle',
                        'description',
                        'keywords',
                    ),
                    'langClassName' => 'BlogCategoryLang',
                    'langTableName' => 'blog_category_lang',
                    'languages' => Yii::app()->params['translatedLanguages'],
                    'defaultLanguage' => Yii::app()->params['defaultLanguage'],
                    'langForeignKey' => 'owner_id',
                    'localizedRelation' => 'i18nBlogCategory',
                    'dynamicLangClass' => true,
                ),
            ));
        }

        return $behaviors;
    }

    public function defaultScope()
    {
        return DMultilangHelper::enabled() ? $this->ml->localizedCriteria() : array();
    }
}