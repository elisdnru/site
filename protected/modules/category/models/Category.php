<?php

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
 * @property string $parent_id
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
 * @method mixed getMenuList($sub=0, $parent=0)
 * @method string getPath($separator='/')
 * @method mixed getBreadcrumbs($lastLink=false)
 */
abstract class Category extends CActiveRecord
{
    public $urlRoute = '';
    public $multiLanguage = false;
    public $indent = 0;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Category the static model class
	 */
	public static function model($className=__CLASS__)
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

    public static function staticRules(){
        return array(
            array('alias, title', 'required'),
            array('alias', 'match', 'pattern' => '#^[a-zA-Z0-9_-]+$#', 'message' => 'Допустимы только латинские символы, цифры и знак подчёркивания'),
            //array('alias', 'unique', 'caseSensitive' => false, 'message' => 'Элемент с таким URL уже существует'),
            array('sort, parent_id', 'numerical', 'integerOnly'=>true),
            array('alias, title, pagetitle, keywords', 'length', 'max'=>255),
            array('text, description', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, sort, alias, title, text, pagetitle, description, keywords, parent_id', 'safe', 'on'=>'search'),
        );
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
        return array(
            'id' => 'ID',
            'sort' => 'Позиция',
            'alias' => 'URL транслитом',
            'title' => 'Наименование',
            'text' => 'Текст',
            'parent_id' => 'Родительский пункт',
            'pagetitle' => 'Заголовок окна',
            'description' => 'Описание',
            'keywords' => 'Ключевые слова',
        );
    }

    /**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($pageSize=10)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.alias',$this->alias,true);
		$criteria->compare('t.title',$this->title,true);
		$criteria->compare('t.text',$this->text,true);
		$criteria->compare('t.pagetitle',$this->pagetitle,true);
		$criteria->compare('t.description',$this->description,true);
		$criteria->compare('t.keywords',$this->keywords,true);
		$criteria->compare('t.parent_id',$this->parent_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$this->multiLanguage && DMultilangHelper::enabled() ? $this->ml->modifySearchCriteria($criteria) : $criteria,
            'sort'=>array(
                'defaultOrder'=>'t.sort ASC, t.title ASC',
            ),
            'pagination'=>array(
                'pageSize'=>$pageSize,
                'pageVar'=>'page',
            ),
		));
	}

    protected function afterFind()
    {
        if (!$this->alias) $this->alias = DTextHelper::strToChpu($this->title);
        if (!$this->pagetitle) $this->pagetitle = strip_tags($this->title);
        if (!$this->description) $this->description = mb_substr(strip_tags($this->text), 0, 255, 'UTF-8');
        parent::afterFind();
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
                'defaultCriteria'=>$this->multiLanguage && DMultilangHelper::enabled() ? array(
                    'with'=>'i18n' . get_class($this),
                    'order'=>'t.sort ASC, t.title ASC'
                ) : array(
                    'order'=>'t.sort ASC, t.title ASC'
                ),
            ),
        );

        if ($this->multiLanguage && DMultilangHelper::enabled())
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
                    'langTableName' => str_replace(array('{{', '}}'), '', $this->tableName()) . '_lang',
                    'languages' => Yii::app()->params['translatedLanguages'],
                    'defaultLanguage' => Yii::app()->params['defaultLanguage'],
                    'langForeignKey' => 'owner_id',
                    'localizedRelation' => 'i18n' . get_class($this),
                    'dynamicLangClass' => true,
                ),
            ));
        }

        return $behaviors;
    }

    public function defaultScope()
    {
        return $this->multiLanguage && DMultilangHelper::enabled() ? $this->ml->localizedCriteria() : array();
    }

    private $_url;

    public function getUrl()
    {
        if ($this->_url === null)
            $this->_url = Yii::app()->createUrl($this->urlRoute, array('category'=>$this->cache(3600)->getPath()));

        return $this->_url;
    }
}