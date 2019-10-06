<?php

namespace app\components\category\models;

use app\components\helpers\TextHelper;
use CActiveDataProvider;
use CActiveRecord;
use CDbCriteria;
use Yii;

/**
 * This is the model class for table "{{category}}".
 *
 * The followings are the available columns in table '{{category}}':
 * @property string $id
 * @property string $sort
 * @property string $alias
 * @property string $title
 * @property string $text
 * @property string $pagetitle
 * @property string $description
 * @property string $keywords
 *
 * DCategoryBehavior
 * @method mixed getArray()
 * @method Category findByAlias($alias)
 * @method mixed getAssocList($parent = 0)
 * @method mixed getAliasList($parent = 0)
 * @method mixed getMenuList($sub = 0, $parent = 0)
 */
abstract class Category extends CActiveRecord
{
    public $urlRoute = '';

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Category the static model class
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
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return self::staticRules();
    }

    public static function staticRules()
    {
        return [
            ['alias, title', 'required'],
            ['alias', 'match', 'pattern' => '#^[a-zA-Z0-9_-]+$#', 'message' => 'Допустимы только латинские символы, цифры и знак подчёркивания'],
            //array('alias', 'unique', 'caseSensitive' => false, 'message' => 'Элемент с таким URL уже существует'),
            ['sort', 'numerical', 'integerOnly' => true],
            ['alias, title, pagetitle, keywords', 'length', 'max' => 255],
            ['text, description', 'safe'],
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            ['id, sort, alias, title, text, pagetitle, description, keywords', 'safe', 'on' => 'search'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return self::staticAtributeLabels();
    }

    public static function staticAtributeLabels()
    {
        return [
            'id' => 'ID',
            'sort' => 'Позиция',
            'alias' => 'URL транслитом',
            'title' => 'Наименование',
            'text' => 'Текст',
            'pagetitle' => 'Заголовок окна',
            'description' => 'Описание',
            'keywords' => 'Ключевые слова',
        ];
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @param int $pageSize
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

        return new CActiveDataProvider($this, [
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
                'class' => \app\components\category\behaviors\CategoryBehavior::class,
                'titleAttribute' => 'title',
                'aliasAttribute' => 'alias',
                'requestPathAttribute' => 'category',
                'defaultCriteria' => [
                    'order' => 't.sort ASC, t.title ASC'
                ],
            ],
        ];
    }

    protected function beforeSave()
    {
        if (parent::beforeSave()) {
            $this->fillDefaultValues();
            return true;
        }
        return false;
    }

    private function fillDefaultValues()
    {
        if (!$this->alias) {
            $this->alias = TextHelper::strToChpu($this->title);
        }
        if (!$this->pagetitle) {
            $this->pagetitle = strip_tags($this->title);
        }
        if (!$this->description) {
            $this->description = mb_substr(strip_tags($this->text), 0, 255, 'UTF-8');
        }
    }

    private $_url;

    public function getUrl()
    {
        if ($this->_url === null) {
            $this->_url = Yii::app()->createUrl($this->urlRoute, ['category' => $this->alias]);
        }

        return $this->_url;
    }
}
