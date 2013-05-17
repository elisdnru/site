<?php

Yii::import('application.modules.category.components.*');
Yii::import('application.modules.page.models.*');

/**
 * This is the model class for table "{{page}}".
 *
 * The followings are the available columns in table '{{page}}':
 * @property integer $id
 * @property string $alias
 * @property string $date
 * @property string $title
 * @property string $hidetitle
 * @property string $pagetitle
 * @property string $description
 * @property string $keywords
 * @property string $text
 * @property string $text_purified
 * @property string $image
 * @property string $image_alt
 * @property string $layout_id
 * @property string $layout_subpages_id
 * @property string $parent_id
 * @property string $system
 *
 * @property string $url
 *
 * DTreeCategoryBehavior
 * @method mixed getArray()
 * @method Page findByAlias($alias)
 * @method Page findByPath($path)
 * @method boolean isChildOf($parent)
 * @method mixed getChildsArray($parent=0)
 * @method mixed getAssocList($parent=0)
 * @method mixed getAliasList($parent=0)
 * @method mixed getTabList($parent=0)
 * @method mixed getMenuList($sub=0, $parent=0)
 * @method string getPath($separator='/')
 * @method mixed getBreadcrumbs($lastLink=false)
 *
 * @method Page multilang()
 */
class Page extends CActiveRecord
{
    const IMAGE_WIDTH = 250;
    const IMAGE_PATH = 'upload/images/pages';

    public $del_image = false;
    public $indent = 0;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className
     * @return \CActiveRecord|\Page the static model class
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
		return '{{page}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('alias, title', 'required'),
            array('alias', 'match', 'pattern' => '#^\w[a-zA-Z0-9_-]+$#', 'message' => 'Допустимы только латинские символы, цифры и знак подчёркивания'),
			array('alias, title, image_alt, pagetitle, keywords', 'length', 'max'=>255),
            array('hidetitle, parent_id, layout_id, layout_subpages_id', 'numerical', 'integerOnly'=>true),
			array('date, text, description, del_image', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, layout_id, layout_subpages_id, alias, date, title, pagetitle, description, keywords, text', 'safe', 'on'=>'search'),
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
			'layout' => array(self::BELONGS_TO, 'PageLayout', 'layout_id'),
			'layout_subpages' => array(self::BELONGS_TO, 'PageLayoutSubpages', 'layout_subpages_id'),
			'parent' => array(self::BELONGS_TO, 'Page', 'parent_id'),
            'child_pages' => array(self::HAS_MANY, 'Page', 'parent_id',
                'order'=>'child_pages.id ASC'
            ),
            'child_pages_count' => array(self::STAT, 'Page', 'parent_id'),
            'files' => array(self::HAS_MANY, 'PageFile', 'material_id',
                'order'=>'files.title DESC'
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
			'layout_id' => 'Шаблон страницы',
			'layout_list_id' => 'Шаблон списка новостей',
			'layout_item_id' => 'Шаблон страницы новости',
			'layout_item_content_id' => 'Шаблон контента новости',
			'layout_subpages_id' => 'Вид списка дочерних страниц',
			'alias' => 'URL транслитом',
			'date' => 'Дата создания',
			'title' => 'Заголовок',
			'hidetitle' => 'Скрыть заголовок',
			'pagetitle' => 'Заголовок окна (title)',
			'description' => 'Описание (description)',
			'keywords' => 'Ключевые слова (keywords)',
			'text' => 'Текст',
			'image' => 'Изображение',
			'del_image' => 'Удалить изображение',
			'image_alt' => 'Описание для изображения',
			'file' => 'Приложенные файлы',
			'parent_id' => 'Родительская страница',
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
		$criteria->compare('t.layout_id',$this->layout_id);
		$criteria->compare('t.layout_subpages_id',$this->layout_subpages_id);
		$criteria->compare('t.alias',$this->alias,true);
		$criteria->compare('t.date',$this->date,true);
		$criteria->compare('t.title',$this->title,true);
		$criteria->compare('t.hidetitle',$this->hidetitle,true);
		$criteria->compare('t.pagetitle',$this->pagetitle,true);
		$criteria->compare('t.description',$this->description,true);
		$criteria->compare('t.keywords',$this->keywords,true);
		$criteria->compare('t.text',$this->text,true);
		$criteria->compare('t.image',$this->image,true);
		$criteria->compare('t.image_alt',$this->image_alt,true);
		$criteria->compare('t.parent_id',$this->parent_id);

        return new DTreeActiveDataProvider($this, array(
            'criteria'=>DMultilangHelper::enabled() ? $this->ml->modifySearchCriteria($criteria) : $criteria,
            'childRelation'=>'child_pages',
            'sort'=>array(
                'defaultOrder'=>'t.alias ASC',
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
                'class'=>'DCategoryTreeBehavior',
                'titleAttribute'=>'title',
                'aliasAttribute'=>'alias',
                'parentAttribute'=>'parent_id',
                'linkActiveAttribute'=>'linkActive',
                'parentRelation'=>'parent',
                'defaultCriteria'=>DMultilangHelper::enabled() ? array(
                    'with'=>'i18nPage',
                    'order'=>'t.parent_id ASC, t.title ASC',
                ) : array(
                    'order'=>'t.parent_id ASC, t.title ASC',
                ),
            ),
            'PurifyText'=>array(
                'class'=>'DPurifyTextBehavior',
                'sourceAttribute'=>'text',
                'destinationAttribute'=>'text_purified',
                'purifierOptions'=> array(
                    'HTML.SafeObject'=>true,
                    'Output.FlashCompat'=>true,
                ),
                'processOnBeforeSave'=>true,
            ),
            'ImageUpload'=>array(
                'class'=>'uploader.components.DFileUploadBehavior',
                'fileAttribute'=>'image',
                'deleteAttribute'=>'del_image',
                'enableWatermark'=>true,
                'filePath'=>self::IMAGE_PATH,
                'defaultThumbWidth'=>self::IMAGE_WIDTH,
            )
        );

        if (DMultilangHelper::enabled())
        {
            $behaviors = array_merge($behaviors, array(
                'ml' => array(
                    'class' => 'ext.multilangual.MultilingualBehavior',
                    'localizedAttributes' => array(
                        'title',
                        'text',
                        'text_purified',
                        'pagetitle',
                        'description',
                        'keywords',
                    ),
                    'langTableName' => 'page_lang',
                    'languages' => Yii::app()->params['translatedLanguages'],
                    'defaultLanguage' => Yii::app()->params['defaultLanguage'],
                    'langForeignKey' => 'owner_id',
                    'localizedRelation' => 'i18nPage',
                    'dynamicLangClass' => false,
                ),
            ));
        }

        return $behaviors;
    }

    public function defaultScope()
    {
        return DMultilangHelper::enabled() ? $this->ml->localizedCriteria() : array();
    }

    protected function afterFind()
    {
        if (!$this->alias)
            $this->alias = DTextHelper::strToChpu($this->title);

        if (!$this->pagetitle)
            $this->pagetitle = strip_tags($this->title);

        parent::afterFind();
    }

    public function allowedForUser(User $user)
    {
        if ($user->access_pages)
        {
            $allowed = $user->accessPagesArray;
            return in_array($this->primaryKey, $allowed) || $this->isChildOf($allowed);
        }
        else
            return true;
    }

    private $_url;

    public function getUrl()
    {
        if ($this->_url === null)
        {
            DUrlRulesHelper::import('page');
            $this->_url = Yii::app()->createUrl('page/page/show', array('path'=>$this->path));
        }
        return $this->_url;
    }

    protected function beforeSave()
    {
        if (!$this->image_alt) $this->image_alt = $this->title;
        return parent::beforeSave();
    }

    protected function afterSave()
    {
        $this->loadFiles();
        parent::afterSave();
    }

    protected function loadFiles()
    {
		if (!empty($_FILES['Page']))
		{
			for ($i = 1; $i < PageFile::FILES_LIMIT + 1; $i++)
			{
				if ($_FILES['Page']['tmp_name']['file_'.$i])
				{
					$file = new PageFile();
					$file->material_id = $this->id;
					$file->file = CUploadedFile::getInstance($this,'file_'.$i);
					$file->save();
				}
				unset($_FILES['Page']['tmp_name']['file_'.$i]);
			}
		}
    }

    protected function beforeDelete()
    {
        $this->delFiles();

        foreach ($this->child_pages as $child)
            $child->delete();

        return parent::beforeDelete();
    }

    protected function delFiles()
    {
        foreach ($this->files as $file)
            $file->delete();
    }
}