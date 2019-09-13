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
 * @method mixed getChildsArray($parent = 0)
 * @method mixed getAssocList($parent = 0)
 * @method mixed getAliasList($parent = 0)
 * @method mixed getTabList($parent = 0)
 * @method string getPath($separator = '/')
 * @method mixed getBreadcrumbs($lastLink = false)
 */
class Menu extends CActiveRecord
{
    public $indent = 0;

    /**
     * Returns the static model of the specified AR class.
     * @return Menu the static model class
     */
    public static function model($className = __CLASS__)
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
        return [
            ['title, link', 'required'],
            ['alias', 'safe'],
            ['sort, parent_id, visible', 'numerical', 'integerOnly' => true],
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            ['id, title, alias, link, sort, parent_id', 'safe', 'on' => 'search'],
        ];
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return [
            'child_items' => [self::HAS_MANY, \Menu::class, 'parent_id',
                'order' => 'child_items.sort ASC, child_items.title ASC'
            ],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'alias' => 'Псевдоним',
            'link' => 'Ссылка',
            'sort' => 'Позиция',
            'parent_id' => 'Родительский пункт',
            'visible' => 'Видимо',
        ];
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return DTreeActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($pageSize = 10)
    {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.title', $this->title, true);
        $criteria->compare('t.alias', $this->alias, true);
        $criteria->compare('t.link', $this->link, true);
        $criteria->compare('t.sort', $this->sort);
        $criteria->compare('t.parent_id', $this->parent_id);
        $criteria->compare('t.visible', $this->visible);

        return new DTreeActiveDataProvider($this, [
            'childRelation' => 'child_items',
            'criteria' => $criteria,
            'sort' => [
                'defaultOrder' => 't.sort ASC, t.title ASC',
            ],
            'pagination' => [
                'pageSize' => $pageSize,
                'pageVar' => 'page',
            ],
        ]);
    }

    public function behaviors()
    {
        return [
            'CategoryBehavior' => [
                'class' => \DCategoryTreeBehavior::class,
                'titleAttribute' => 'title',
                'aliasAttribute' => 'alias',
                'parentAttribute' => 'parent_id',
                'linkActiveAttribute' => 'linkActive',
                'parentRelation' => 'parent',
                'defaultCriteria' => [
                    'order' => 't.sort ASC, t.title ASC'
                ],
            ],
        ];
    }

    public function getMenuList($parent = 0, $sub = true, $withhidden = false)
    {
        $items = [];

        if ((int)$parent) {
            $items = $this->_getMenuListRecursive($parent, $sub, $withhidden);
        } elseif ($parent) {
            $parentitem = $this->cache(1000)->find([
                'select' => 'id',
                'condition' => 'alias = :id',
                'params' => [':id' => $parent],
            ]);

            if ($parentitem) {
                $items = $this->_getMenuListRecursive($parentitem->id, $sub, $withhidden);
            }
        }

        return $items;
    }

    private function _getMenuListRecursive($parent, $sub = true, $withhidden = false)
    {
        $criteria = new CDbCriteria;
        $criteria->addCondition('t.parent_id = :parent');
        $criteria->params[':parent'] = (int)$parent;
        $criteria->order = 't.sort ASC, t.title ASC';

        if (!$withhidden) {
            $criteria->addCondition('visible=1');
        }

        $items = $this->cache(1000)->findAll($criteria);

        $itArray = [];
        foreach ($items as $item) {
            $active = $item->getLinkActive();
            $itArray[$item->id] = [
                    'id' => $item->id,
                    'label' => $item->title,
                    'url' => $item->url,
                    'active' => $active,
                    'itemOptions' => ['class' => 'item_' . $item->id],
                    'linkOptions' => $active ? ['rel' => 'nofollow'] : [],
                ] + ($sub ? ['items' => $this->_getMenuListRecursive($item->id, $sub - 1, $withhidden)] : []);
        }

        return $itArray;
    }

    private function getLinkActive()
    {
        $currentUri = Yii::app()->getRequest()->getRequestUri();
        $itemUri = $this->getUrl();
        return strpos('/' . $currentUri . '/', '/' . $itemUri . '/') === 0 || strpos('/' . $currentUri . '?', '/' . $itemUri . '?') === 0;
    }

    private $_url;

    public function getUrl()
    {
        if ($this->_url === null) {
            DUrlRulesHelper::import('main');
            $url = $this->link ? $this->link : '#';
            if (preg_match('|^http:\/\/|', $url, $m)) {
                $this->_url = Yii::app()->createUrl('/main/default/url', ['a' => $url]);
            } else {
                $this->_url = $this->link != '/index' ? $this->link : '/';
            }
        }

        return $this->_url;
    }
}
