<?php

namespace app\components\category\models;

use app\components\TreeActiveDataProvider;
use CActiveDataProvider;
use CDbCriteria;
use Yii;

/**
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
    public $indent = 0;

    public function rules(): array
    {
        return array_merge(self::staticRules(), [
            ['parent_id', \app\components\validators\ExistOrEmpty::class, 'className' => get_class($this), 'attributeName' => 'id'],
            ['parent_id', 'safe', 'on' => 'search'],
        ]);
    }

    public function attributeLabels(): array
    {
        return array_merge(self::staticAtributeLabels(), [
            'parent_id' => 'Родительский пункт',
        ]);
    }

    public function search($pageSize = 10): CActiveDataProvider
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
        $criteria->compare('t.parent_id', $this->parent_id);

        return new TreeActiveDataProvider($this, [
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
        return array_replace(parent::behaviors(), [
            'CategoryBehavior' => [
                'class' => \app\components\category\behaviors\CategoryTreeBehavior::class,
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

    public function getUrl(): string
    {
        if ($this->_url === null) {
            $this->_url = Yii::app()->createUrl($this->urlRoute, ['category' => $this->cache(3600)->getPath()]);
        }

        return $this->_url;
    }
}
