<?php

DUrlRulesHelper::import('shop');
Yii::import('application.modules.category.models.*');

/**
 * This is the model class for table "{{shop_category}}".
 *
 * The followings are the available columns in table '{{shop_category}}':
 * @property string $type
 */
class ShopCategory extends TreeCategory
{
    public $urlRoute = '/shop/default/category';
    protected $current_type = 0;

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
		return '{{shop_category}}';
	}

    public function rules()
    {
        return array_merge(parent::rules(), array(
            array('type_id', 'required'),
            array('type_id', 'numerical', 'integerOnly'=>true),
            array('type_id', 'safe', 'on'=>'search'),
            array('parent_id', 'DExistOrEmpty', 'className' => 'PortfolioCategory', 'attributeName' => 'id'),
        ));
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), array(
            'type_id'=>'Тип товара',
        ));
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array_merge(parent::relations(), array(
            'type' => array(self::BELONGS_TO, 'ShopType', 'type_id'),
            'parent' => array(self::BELONGS_TO, 'ShopCategory', 'parent_id'),
            'child_items' => array(self::HAS_MANY, 'ShopCategory', 'parent_id',
                'order'=>'child_items.sort ASC'
            ),
            'items_count' => array(self::STAT, 'ShopProduct', 'category_id',
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
        $criteria->compare('t.type_id',$this->type_id,true);
        $criteria->compare('t.pagetitle',$this->pagetitle,true);
        $criteria->compare('t.description',$this->description,true);
        $criteria->compare('t.keywords',$this->keywords,true);
        $criteria->compare('t.parent_id',$this->parent_id);

        return new DTreeActiveDataProvider($this, array(
            'childRelation'=>'child_items',
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
        return array_replace(parent::behaviors(), array(
            'CategoryBehavior'=>array(
                'class'=>'category.components.DCategoryTreeBehavior',
                'titleAttribute'=>'title',
                'aliasAttribute'=>'alias',
                'parentAttribute'=>'parent_id',
                'parentRelation'=>'parent',
                'requestPathAttribute'=>'category',
                'defaultCriteria'=>array(
                    'join'=>'LEFT OUTER JOIN `{{shop_type}}` `type` ON `t`.type_id=`type`.id',
                    'order'=>'`type`.sort ASC, t.sort ASC, t.title ASC'
                ),
            ),
        ));
    }

    /**
     * scope
     * @param $type_id
     * @return ShopCategory
     */
    public function type($type_id)
    {
        if ($type_id)
        {
            $this->getDbCriteria()->mergeWith(array(
                'condition' => 't.type_id=:type',
                'params'=>array(':type'=>$type_id),
            ));
        }
        $this->current_type = $type_id;
        return $this;
    }

    protected function afterSave()
    {
        foreach ($this->child_items as $child){
            $child->type_id = $this->type_id;
            $child->save();
        }
        parent::afterSave();
    }

    /**
     * @return array
     */
    public function getBrandMenuList()
    {
        $categories = $this->findAll(array('order'=>'t.sort ASC, t.title ASC'));

        $items = array();

        foreach ($categories as $model)
        {
            $items[] = array(
                'label'=>$model->title,
                'url'=>$model->getUrl(),
                'active'=>$model->getLinkActive(),
                'items'=>ShopBrand::model()->category($model)->getCurrentMenuList()
            );
        }

        return $items;
    }

    /**
     * Returns tabulated array ($id=>$title, $id=>$title, ...)
     * @param mixed $parent number, object or array of numbers
     * @return array
     */
    public function getTabList($parent=0)
    {
        $criteria = $this->getDbCriteria();

        $criteria->with = array('type');
        $criteria->order = 'type.sort ASC';

        if (!$parent)
            $parent = $this->id;

        if ($parent)
            $criteria->compare('t.id', $this->getChildsArray($parent));

        $items = $this->findAll($criteria);

        $categories = array();
        foreach ($items as $item){
            $categories[$item->parent_id][] = $item;
        }

        return $this->_getTabListRecursive($categories, $parent);
    }

    private function _getTabListRecursive($items, $parent, $indent=0)
    {
        $parent = (int)$parent;
        $resultArray = array();
        if (isset($items[$parent]) && $items[$parent]){
            foreach ($items[$parent] as $item){
                $resultArray = $resultArray + array($item->id => $item->type->title . ' - ' . str_repeat('-- ', $indent) . $item->title) + $this->_getTabListRecursive($items, $item->id, $indent + 1);
            }
        }
        return $resultArray;
    }

    /**
     * Returns tabulated array ($url=>$title, $url=>$title, ...)
     * @param mixed $parent number, object or array of numbers
     * @return array
     */
    public function getUrlList($parent=0)
    {
        $criteria = $this->getDbCriteria();

        $criteria->with = array('type');
        $criteria->order = 'type.sort ASC';

        if (!$parent)
            $parent = $this->id;

        if ($parent)
            $criteria->compare('t.id', $this->getChildsArray($parent));

        $items = $this->findAll($criteria);

        $categories = array();
        foreach ($items as $item){
            $categories[$item->parent_id][] = $item;
        }

        return $this->_getUrlListRecursive($categories, $parent);
    }

    private function _getUrlListRecursive($items, $parent, $indent=0)
    {
        $parent = (int)$parent;
        $resultArray = array();
        if (isset($items[$parent]) && $items[$parent]){
            foreach ($items[$parent] as $item){
                $resultArray = CArray::merge($resultArray, array($item->getUrl() => $item->type->title . ' - ' . str_repeat('-- ', $indent) . $item->title), $this->_getTabListRecursive($items, $item->id, $indent + 1));
            }
        }
        return $resultArray;
    }

    private $_url;

    public function getUrl()
    {
        if ($this->_url === null)
        {
			DUrlRulesHelper::import('shop');
            $params = array();
            $params['type'] = $this->type ? $this->type->alias : 'all';
            $params['category'] = $this->cache(3600)->getPath();
            $this->_url = Yii::app()->createUrl($this->urlRoute, $params);
        }
        return $this->_url;
    }
}