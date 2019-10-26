<?php

namespace app\modules\menu\models;

use app\components\category\behaviors\CategoryTreeBehavior;
use app\components\category\TreeActiveDataProvider;
use app\components\category\models\Category;
use CActiveRecord;
use CDbCriteria;
use Yii;

/**
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
 * @method mixed getChildrenArray($parent = 0)
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
     * @param string|null $className
     * @return CActiveRecord|static
     */
    public static function model($className = null): self
    {
        return parent::model($className ?: static::class);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName(): string
    {
        return 'menu_items';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules(): array
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
    public function relations(): array
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return [
            'child_items' => [self::HAS_MANY, self::class, 'parent_id',
                'order' => 'child_items.sort ASC, child_items.title ASC'
            ],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels(): array
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
     * @param int $pageSize
     * @return TreeActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($pageSize = 10): TreeActiveDataProvider
    {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.title', $this->title, true);
        $criteria->compare('t.alias', $this->alias, true);
        $criteria->compare('t.link', $this->link, true);
        $criteria->compare('t.sort', $this->sort);
        $criteria->compare('t.parent_id', $this->parent_id);
        $criteria->compare('t.visible', $this->visible);

        return new TreeActiveDataProvider($this, [
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

    public function behaviors(): array
    {
        return [
            'CategoryBehavior' => [
                'class' => CategoryTreeBehavior::class,
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

    public function getMenuList($parent = 0, $sub = true, $withhidden = false): array
    {
        $items = [];

        if ((int)$parent) {
            $items = $this->getMenuListRecursive($parent, $sub, $withhidden);
        } elseif ($parent) {
            $parentitem = $this->cache(1000)->find([
                'select' => 'id',
                'condition' => 'alias = :id',
                'params' => [':id' => $parent],
            ]);

            if ($parentitem) {
                $items = $this->getMenuListRecursive($parentitem->id, $sub, $withhidden);
            }
        }

        return $items;
    }

    private function getMenuListRecursive($parent, $sub = true, $withhidden = false): array
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
                    'url' => $item->getUrl(),
                    'active' => $active,
                    'itemOptions' => ['class' => 'item_' . $item->id],
                    'linkOptions' => $active ? ['rel' => 'nofollow'] : [],
                ] + ($sub ? ['items' => $this->getMenuListRecursive($item->id, $sub - 1, $withhidden)] : []);
        }

        return $itArray;
    }

    private function getLinkActive(): bool
    {
        $currentUri = Yii::app()->getRequest()->getRequestUri();
        $itemUri = $this->getUrl();
        return strpos('/' . $currentUri . '/', '/' . $itemUri . '/') === 0 || strpos('/' . $currentUri . '?', '/' . $itemUri . '?') === 0;
    }

    private $cachedUrl;

    public function getUrl(): string
    {
        if ($this->cachedUrl === null) {
            $this->cachedUrl = $this->link !== '/index' ? $this->link : '/';
        }

        return $this->cachedUrl;
    }
}
