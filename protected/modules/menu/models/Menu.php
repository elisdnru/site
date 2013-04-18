<?php
/**
 * This is the model class for table "{{menu}}".
 *
 * The followings are the available columns in table '{{menu}}':
 * @property integer $id
 * @property string $title
 * @property string $alias
 * @property string $link
 * @property integer $sort
 * @property integer $parent_id
 * @property integer $visible
 *
 * DTreeCategoryBehavior
 * @method mixed getArray()
 * @method Category findByAlias($alias)
 * @method Category findByPath($path)
 * @method boolean isChildOf($parent)
 * @method mixed getChildsArray($parent=0)
 * @method mixed getAssocList($parent=0)
 * @method mixed getAliasList($parent=0)
 * @method mixed getTabList($parent=0)
 * @method string getPath($separator='/')
 * @method mixed getBreadcrumbs($lastLink=false)
 *
 * @method Menu multilang()
 */
class Menu extends CActiveRecord
{
    public $indent = 0;

	/**
	 * Returns the static model of the specified AR class.
	 * @return Menu the static model class
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
		return '{{menu}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, link', 'required'),
			array('alias', 'safe'),
			array('sort, parent_id, visible', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, alias, link, sort, parent_id', 'safe', 'on'=>'search'),
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
            'child_items' => array(self::HAS_MANY, 'Menu', 'parent_id',
                'order'=>'child_items.sort ASC, child_items.title ASC'
            ),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Заголовок',
			'alias' => 'Псевдоним',
			'link' => 'Ссылка',
			'sort' => 'Позиция',
			'parent_id' => 'Родительский пункт',
			'visible' => 'Видимо',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return DTreeActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($pageSize=10)
	{
		$criteria=new CDbCriteria;

		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.title',$this->title,true);
		$criteria->compare('t.alias',$this->alias,true);
		$criteria->compare('t.link',$this->link,true);
		$criteria->compare('t.sort',$this->sort);
		$criteria->compare('t.parent_id',$this->parent_id);
		$criteria->compare('t.visible',$this->visible);

        return new DTreeActiveDataProvider($this, array(
            'childRelation'=>'child_items',
            'criteria'=>DMultilangHelper::enabled() ? $this->ml->modifySearchCriteria($criteria) : $criteria,
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
                'linkActiveAttribute'=>'linkActive',
                'parentRelation'=>'parent',
                'defaultCriteria'=>DMultilangHelper::enabled() ? array(
                    'with'=>'i18nMenu',
                    'order'=>'t.sort ASC, t.title ASC'
                ) : array(
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
                    ),
                    'langTableName' => 'menu_lang',
                    'languages' => Yii::app()->params['translatedLanguages'],
                    'defaultLanguage' => Yii::app()->params['defaultLanguage'],
                    'langForeignKey' => 'owner_id',
                    'localizedRelation' => 'i18nMenu',
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

    public function getMenuList($parent = 0, $sub = true, $withhidden = false)
    {
        $items = array();

        if ((int)$parent)
            $items = $this->_getMenuListRecursive($parent, $sub, $withhidden);
        elseif ($parent)
        {
            $parentitem = $this->cache(1000)->find(array(
                'select'=>'id',
                'condition'=>'alias = :id',
                'params'=>Array(':id' => $parent),
            ));

            if ($parentitem)
                $items = $this->_getMenuListRecursive($parentitem->id, $sub, $withhidden);
        }

        return $items;
    }

    protected function _getMenuListRecursive ($parent, $sub = true, $withhidden=false)
    {
        $criteria = new CDbCriteria;
        $criteria->addCondition('t.parent_id = :parent');
        $criteria->params[':parent'] = (int)$parent;
        $criteria->order = 't.sort ASC, t.title ASC';

        if (!$withhidden)
            $criteria->addCondition('visible=1');

        $items = $this->cache(1000)->findAll($criteria);

        $itArray = Array();
        foreach ($items as $item)
        {
            $itArray[$item->id] = array(
                'id'=>$item->id,
                'label'=>$item->title,
                'url'=>$item->url,
                'itemOptions'=>array('class'=>'item_' . $item->id),
                'active'=>$item->linkActive,
            ) + ($sub ? array('items'=>$this->_getMenuListRecursive($item->id, $sub - 1, $withhidden)) : array());
        }

        return $itArray;
    }

    protected function getLinkActive()
    {
        $uri = Yii::app()->getRequest()->getOriginalRequestUri();
        $uri = $uri != '/' . Yii::app()->language . '/' ? $uri : '/index';
        return strpos($uri, $this->getUrl()) === 0;
    }

    protected function getUrl()
    {
        $url = $this->link ? $this->link : '#';

        if (preg_match('|^http:\/\/|', $url, $m))
        {
            $url = Yii::app()->createUrl('/main/default/url', array('a'=>$url));
        }
        else
            $url = DMultilangHelper::addLangToUrl($this->link);

        return $url;
    }
}