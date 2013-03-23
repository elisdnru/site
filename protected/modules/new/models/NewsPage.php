<?php

Yii::import('page.models.Page');

/**
 * This is the model class for table "{{new_page}}".
 *
 * The followings are the available columns in table '{{new_page}}':
 * @property integer $id
 * @property integer $page_id
 * @property string $list_layout
 * @property string $show_layout
 *
 * @property Page $page
 */
class NewsPage extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return NewsPage the static model class
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
		return '{{new_page}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('page_id, list_layout, show_layout, show_view', 'required'),
			array('page_id', 'numerical', 'integerOnly'=>true),
			array('page_id', 'unique', 'className'=>'NewsPage'),
			array('list_layout, show_layout, show_view', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, page_id, list_layout, show_layout, show_view', 'safe', 'on'=>'search'),
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
            'page' => array(self::BELONGS_TO, 'Page', 'page_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'page_id' => 'Страница',
			'list_layout' => 'Шаблон списка',
			'show_layout' => 'Шаблон новости',
			'show_view' => 'Контент новости',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('page_id',$this->page_id);
		$criteria->compare('list_layout',$this->list_layout,true);
		$criteria->compare('show_layout',$this->show_layout,true);

		$criteria->with = array('page');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'page.parent_id ASC',
			),
			'pagination'=>array(
				'pageSize'=>$pageSize,
				'pageVar'=>'page',
			),
		));
	}

    public function getPagesArray($parent = 0)
    {
        $newPages = $this->findAll();
        $result = array();

        foreach ($newPages as $newPage)
        {
            $page = $newPage->page;

            if ((int)$parent)
            {
                if ($page->id == $parent || $page->isChildOf($parent))
                    $result[] = $page->id;
            }
            else
                $result[] = $page->id;
        }

        return $result;
    }

    public function getPages($parent = 0)
    {
        $newPages = $this->findAll();
        $result = array();

        foreach ($newPages as $newPage)
        {
            $page = $newPage->page;

            if ((int)$parent)
            {
                if ($page->id == $parent || $page->isChildOf($parent))
                    $result[$page->id] = $page->fullTitle;
            } elseif ($page)
                $result[$page->id] = $page->fullTitle;
        }

        return $result;
    }

    public function getAssocList($parent = 0)
    {
        $newPages = $this->findAll();
        $result = array();

        foreach ($newPages as $newPage)
        {
            $page = $newPage->page;

            if ((int)$parent)
            {
                if ($page->id == $parent || $page->isChildOf($parent))
                    $result[$newPage->id] = $page->fullTitle;
            } elseif ($page)
                $result[$newPage->id] = $page->fullTitle;
        }

        return $result;
    }

    public function getListLayouts()
    {
        return array(
            'default'=>'По умолчанию',
            'greed'=>'Сетка',
            'titles'=>'Заголовки',
        );
    }

    public function getShowLayouts()
    {
        return array_merge(
            array('default'=>'По умолчанию'),
            PageLayout::model()->getAliasList()
        );
    }

    public function getShowViews()
    {
        return array(
            'default'=>'По умолчанию',
            'data'=>'Страница',
            'simple'=>'Простой',
        );
    }

    public function getListLayout($page_id)
    {
        $model = $this->findByAttributes(array('page_id'=>$page_id));
        return $model ? $model->list_layout : '';
    }

    public function getShowLayout($page_id)
    {
        $model = $this->findByAttributes(array('page_id'=>$page_id));
        return $model ? $model->show_layout : '';
    }

    public function getShowView($page_id)
    {
        $model = $this->findByAttributes(array('page_id'=>$page_id));
        return $model ? $model->show_view : '';
    }

}