<?php

DUrlRulesHelper::import('shop');
Yii::import('category.models.*');

/**
 * This is the model class for table "{{shop_category}}".
 *
 * The followings are the available columns in table '{{shop_category}}':
 * @property string $type
 * @property ShopBrandCategory[] $brand_categories
 * @property ShopCategory[] $categories
 */
class ShopBrand extends Category
{
    public $urlRoute = '/shop/default/brand';

    protected $current_category;
    protected $current_category_id;
    protected $current_type;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ShopCategory the static model class
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
		return '{{shop_brand}}';
	}

    public function rules()
    {
        return array_merge(parent::rules(), array(
            array('categoriesArray', 'safe'),
        ));
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array_merge(parent::relations(), array(
            'type' => array(self::BELONGS_TO, 'ShopType', 'type_id'),
            'items_count' => array(self::STAT, 'ShopProduct', 'brand_id',
                'condition'=>'public = 1',
            ),
            'brand_categories' => array(self::HAS_MANY, 'ShopBrandCategory', 'brand_id',
            ),
            'categories'=>array(self::MANY_MANY, 'ShopCategory', '{{shop_brand_category}}(brand_id, category_id)',
                'order'=>'categories.sort ASC, categories.title ASC',
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
        $criteria->compare('t.type_id',$this->type_id,true);
        $criteria->compare('t.pagetitle',$this->pagetitle,true);
        $criteria->compare('t.description',$this->description,true);
        $criteria->compare('t.keywords',$this->keywords,true);
        $criteria->compare('t.parent_id',$this->parent_id);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
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
        return array(
            'CategoryBehavior'=>array(
                'class'=>'category.components.DCategoryBehavior',
                'titleAttribute'=>'title',
                'aliasAttribute'=>'alias',
                'linkActiveAttribute'=>'linkActive',
                'requestPathAttribute'=>'type',
                'defaultCriteria'=>array(
                    'order'=>'t.sort ASC, t.title ASC'
                ),
            ),
            'MultiList'=>array(
                'class'=>'DMultiplyListBehavior',
                'attribute'=>'categoriesArray',
                'relation'=>'categories',
                'relationPk'=>'id',
            ),
        );
    }

    // scope
    public function category(ShopCategory $category)
    {
        if ($category)
        {
            $this->getDbCriteria()->mergeWith(array(
                'condition' => 'brand_categories.category_id=:category',
                'params'=>array(':category'=>$category->id),
                'with'=>'brand_categories',
            ));

            $this->current_category_id = $category->id;
            $this->current_category = $category->path;
            $this->current_type = $category->type ? $category->type->alias : '';
        }
        else
        {
            $this->current_category_id = 0;
            $this->current_category = '';
            $this->current_type = '';
        }


        return $this;
    }

    protected function afterSave()
    {
        $this->saveCategories();
        parent::afterSave();
    }

    protected function afterDelete()
    {
        $this->clearCategories();
        parent::afterDelete();
    }

    protected function saveCategories()
    {
        foreach ($this->brand_categories as $brandCategory)
            $brandCategory->delete();

        if (is_array($this->categoriesArray))
        {
            foreach ($this->categoriesArray as $category_id)
            {
                $brandCategory = new ShopBrandCategory();
                $brandCategory->brand_id = $this->id;
                $brandCategory->category_id = $category_id;
                $brandCategory->save();
            }
        }
    }

    protected function clearCategories()
    {
        foreach ($this->brand_categories as $brandCategory)
            $brandCategory->delete();
    }

    public function getCurrentMenuList()
    {
        $brands = $this->findAll(array('order'=>'t.sort ASC, t.title ASC'));

        $items = array();

        foreach ($brands as $model)
        {
            $fullUrl = $this->createFullUrl($model);
            $items[] = array(
                'label'=>$model->title,
                'url'=>$fullUrl,
                'active'=>Yii::app()->request->requestUri == $fullUrl,
            );
        }

        return $items;
    }

    protected function createFullUrl($model)
    {
        return Yii::app()->createUrl('shop/default/brand', array('brand'=>$model->alias, 'type'=>$this->current_type, 'category'=>$this->current_category));
    }

    private $_url;

    public function getUrl()
    {
        if ($this->_url === null)
        {
            DUrlRulesHelper::import('shop');
            $this->_url = Yii::app()->createUrl('/shop/default/brand', array('brand'=>$this->alias));
        }

        return $this->_url;
    }
}