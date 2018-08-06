<?php

/**
 * This is the model class for table "{{category}}".
 *
 * The followings are the available columns in table '{{category}}':
 *
 * @property string $parent_id
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
 * @method mixed getMenuList($sub = 0, $parent = 0)
 * @method string getPath($separator = '/')
 * @method mixed getBreadcrumbs($lastLink = false)
 */
abstract class TreeCategory extends Category
{
    public $urlRoute = '';
    public $indent = 0;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return TreeCategory the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array_merge(self::staticRules(), [
            ['parent_id', 'DExistOrEmpty', 'className' => get_class($this), 'attributeName' => 'id'],
            ['parent_id', 'safe', 'on' => 'search'],
        ]);
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array_merge(self::staticAtributeLabels(), [
            'parent_id' => 'Родительский пункт',
        ]);
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($pageSize = 10)
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.alias', $this->alias, true);
        $criteria->compare('t.title', $this->title, true);
        $criteria->compare('t.text', $this->text, true);
        $criteria->compare('t.pagetitle', $this->pagetitle, true);
        $criteria->compare('t.description', $this->description, true);
        $criteria->compare('t.keywords', $this->keywords, true);
        $criteria->compare('t.parent_id', $this->parent_id);

        return new DTreeActiveDataProvider($this, [
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
        return array_replace(parent::behaviors(), [
            'CategoryBehavior' => [
                'class' => 'category.components.DCategoryTreeBehavior',
                'titleAttribute' => 'title',
                'aliasAttribute' => 'alias',
                'parentAttribute' => 'parent_id',
                'requestPathAttribute' => 'category',
                'parentRelation' => 'parent',
                'defaultCriteria' => [
                    'order' => 't.sort ASC, t.title ASC'
                ],
            ],
        ]);
    }

    private $_url;

    public function getUrl()
    {
        if ($this->_url === null) {
            $this->_url = Yii::app()->createUrl($this->urlRoute, ['category' => $this->cache(3600)->getPath()]);
        }

        return $this->_url;
    }
}
