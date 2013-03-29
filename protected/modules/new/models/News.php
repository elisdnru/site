<?php

Yii::import('application.modules.comment.components.DICommentDepends');
Yii::import('application.modules.comment.models.Comment');
Yii::import('application.modules.new.models.*');
Yii::import('application.modules.page.models.Page');
Yii::import('application.modules.user.models.User');
Yii::import('application.modules.gallery.models.Gallery');

/**
 * This is the model class for table "{{new}}".
 *
 * The followings are the available columns in table '{{new}}':
 * @property integer $id
 * @property string $date
 * @property string $page_id
 * @property integer $author_id
 * @property string $alias
 * @property string $title
 * @property string $pagetitle
 * @property string $description
 * @property string $keywords
 * @property string $short
 * @property string $short_purified
 * @property string $text
 * @property string $text_purified
 * @property string $image
 * @property string $image_width
 * @property string $image_height
 * @property string $image_alt
 * @property integer $image_show
 * @property integer $gallery_id
 * @property integer $group_id
 * @property integer $public
 * @property integer $inhome
 * @property integer $important
 * @property integer $actual
 * @property integer $comments_count
 * @property integer $comments_new_count
 *
 * @property string $url
 * @property string $imageUrl
 * @property string $imageThumdUrl
 *
 * @method News published()
 * @method News multilang()
 */

class News extends CActiveRecord implements DICommentDepends
{

    const IMAGE_WIDTH = 250;
    const IMAGE_PATH = 'upload/images/news';

	public $del_image = false;

    public $newgroup = '';

    /**
     * Returns the static model of the specified AR class.
     * @param string $className
     * @return News the static model class
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
		return '{{new}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date, page_id, alias, title', 'required'),
			array('author_id, page_id, group_id, public, inhome, important, actual, image_show, gallery_id', 'numerical', 'integerOnly'=>true),
            array('author_id', 'exists', 'className' => 'User', 'attributeName' => 'id'),
            array('page_id', 'exists', 'className' => 'Page', 'attributeName' => 'id'),
            array('gallery_id', 'exists', 'className' => 'Gallery', 'attributeName' => 'id'),
            array('group_id', 'exists', 'className' => 'NewsGroup', 'attributeName' => 'id'),
            array('date', 'date', 'format'=>'yyyy-MM-dd hh:mm:ss'),
			array('short, text, description, del_image', 'safe'),
            array('title, alias, newgroup, image_alt, pagetitle, keywords', 'length', 'max'=>'255'),
            array('alias', 'match', 'pattern' => '#^\w[a-zA-Z0-9_-]+$#', 'message' => 'Допустимы только латинские символы, цифры и знак подчёркивания'),
            array('alias', 'unique', 'caseSensitive' => false, 'message' => 'Такой {attribute} уже используется'),
            array('image','file','types'=>'jpg,jpeg,gif,png','allowEmpty'=>true,'safe'=>false),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, date, page_id, author_id, title, pagetitle, description, keywords, image_alt, text, public, inhome, important, actual, gallery_id, group_id', 'safe', 'on'=>'search'),
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
			'author' => array(self::BELONGS_TO, 'User', 'author_id'),
			'gallery' => array(self::BELONGS_TO, 'Gallery', 'gallery_id'),
			'group' => array(self::BELONGS_TO, 'NewsGroup', 'group_id'),
            'files' => array(self::HAS_MANY, 'NewsFile', 'material_id',
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
			'date' => 'Дата',
			'page_id' => 'Раздел',
			'author_id' => 'Автор',
			'title' => 'Заголовок',
			'alias' => 'URL транслитом',
			'pagetitle' => 'Заголовок страницы (title)',
			'description' => 'Описание (description)',
			'keywords' => 'Ключевые слова (keywords)',
			'short' => 'Превью',
			'text' => 'Текст',
			'image' => 'Картинка для статьи',
			'del_image' => 'Удалить изображение',
			'image_alt' => 'Описание изображения (по умолчанию как заголовок)',
			'image_show' => 'Отображать при открытии новости',
			'files' => 'Приложенные файлы',
			'gallery_id' => 'Фотогалерея',
			'group_id' => 'Выберите тематическую группу',
			'newgroup' => '...или введите имя новой',
			'public' => 'Опубликовано',
			'inhome' => 'На главной странице',
			'important' => 'Важное',
			'actual' => 'Актуально',
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
        $criteria->compare('t.date',$this->date,true);

        $user = User::model()->findByPk(Yii::app()->user->id);

        if ($user && $user->access_pages)
        {
            if ($this->page_id)
            {
                $page = Page::model()->findByPk($this->page_id);

                if ($page && $page->allowedForUser($user))
                    $criteria->compare('t.page_id ', $this->page_id);
            }
            else
            {
                $categories = NewsPage::model()->getPagesArray($user->accessPagesArray);
                $criteria->addInCondition('t.page_id', $categories);
            }
        }
        else
            $criteria->compare('t.page_id',$this->page_id);

        $criteria->compare('t.author_id',$this->author_id);
        $criteria->compare('t.alias',$this->alias,true);
        $criteria->compare('t.title',$this->title,true);
        $criteria->compare('t.pagetitle',$this->pagetitle,true);
        $criteria->compare('t.description',$this->description,true);
        $criteria->compare('t.keywords',$this->keywords,true);
        $criteria->compare('t.short',$this->short,true);
        $criteria->compare('t.text',$this->text,true);
        $criteria->compare('t.image',$this->image,true);
        $criteria->compare('t.image_alt',$this->image_alt);
        $criteria->compare('t.image_show',$this->image_show);
        $criteria->compare('t.public',$this->public);
        $criteria->compare('t.inhome',$this->inhome);
        $criteria->compare('t.gallery_id',$this->gallery_id);
        $criteria->compare('t.group_id',$this->group_id);
        $criteria->compare('t.important',$this->important);

        $criteria->with = array('page', 'author', 'group');

        return new CActiveDataProvider($this, array(
            'criteria'=>DMultilangHelper::enabled() ? $this->ml->modifySearchCriteria($criteria) : $criteria,
            'sort'=>array(
                'defaultOrder'=>'t.date DESC',
                'attributes'=>array(
                    'date'=>array(
                        'asc'=>'t.date ASC',
                        'desc'=>'t.date DESC',
                    ),
                    'title'=>array(
                        'asc'=>'t.title ASC',
                        'desc'=>'t.title DESC',
                    ),
                    'category_id'=>array(
                        'asc'=>'category.title ASC',
                        'desc'=>'category.title DESC',
                    ),
                    'author_id'=>array(
                        'asc'=>'author.username ASC',
                        'desc'=>'author.username DESC',
                    ),
                    'group_id'=>array(
                        'asc'=>'group.title ASC',
                        'desc'=>'group.title DESC',
                    ),
                    'public',
                    'actual',
                    'inhome',
                )
            ),
            'pagination'=>array(
                'pageSize'=>$pageSize,
                'pageVar'=>'page',
            ),
        ));
    }

    public function defaultScope()
    {
        return DMultilangHelper::enabled() ? $this->ml->localizedCriteria() : array();
    }

    public function scopes()
    {
        return array(
            'published'=>array(
                'condition'=>'t.public=1 AND t.date <= NOW()',
            ),
            'inhome'=>array(
                'condition'=>'t.inhome=1',
            ),
        );
    }

    public function behaviors()
    {
        $behaviors = array(
            'PurifyShort'=>array(
                'class'=>'DPurifyTextBehavior',
                'sourceAttribute'=>'short',
                'destinationAttribute'=>'short_purified',
                'purifierOptions'=> array(
                    'Attr.AllowedRel'=>array('nofollow'),
                    'HTML.Nofollow' => true,
                ),
                'processOnBeforeSave'=>true,
            ),
            'PurifyText'=>array(
                'class'=>'DPurifyTextBehavior',
                'sourceAttribute'=>'text',
                'destinationAttribute'=>'text_purified',
                'purifierOptions'=> array(
                    'Attr.AllowedRel'=>array('nofollow'),
                    'HTML.SafeObject'=>true,
                    'Output.FlashCompat'=>true,
                ),
                'processOnBeforeSave'=>true,
            ),
            'ImageUpload'=>array(
                'class'=>'uploader.components.DFileUploadBehavior',
                'fileAttribute'=>'image',
                'deleteAttribute'=>'del_image',
                'filePath'=>self::IMAGE_PATH,
                'defaultThumbWidth'=>self::IMAGE_WIDTH,
                'imageWidthAttribute'=>'image_width',
                'imageHeightAttribute'=>'image_height',
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
                    ),
                    'langClassName' => 'NewsLang',
                    'langTableName' => 'new_lang',
                    'languages' => Yii::app()->params['translatedLanguages'],
                    'defaultLanguage' => Yii::app()->params['defaultLanguage'],
                    'langForeignKey' => 'owner_id',
                    'dynamicLangClass' => false,
                ),
            ));
        }

        return $behaviors;
    }
	
    protected function afterFind()
    {
        if (!$this->pagetitle)
            $this->pagetitle = strip_tags($this->title);

        if (!$this->description)
            $this->description = strip_tags($this->short);

        parent::afterFind();
    }
    
    protected function beforeSave()
    {
        if (parent::beforeSave())
        {
            $this->processThematicGroup();

			if (!$this->alias)
				$this->alias = mb_strtolower(DTextHelper::strToChpu($this->title), 'UTF-8');

            if (!$this->author_id)
                $this->author_id = Yii::app()->user->id;

            if (!$this->image_alt)
                $this->image_alt = $this->title;

            return true;
        }
        else
            return false;
    }

    protected function processThematicGroup()
    {
        if ($this->newgroup)
        {
            $group = new NewsGroup;
            $group->title = $this->newgroup;

            if ($group->save())
            {
                $this->group_id = $group->id;
                $this->newgroup = '';
            }
        }
    }

    protected function afterSave()
    {
        $this->loadFiles();
        parent::afterSave();
    }

    protected function loadFiles()
    {
        if (isset($_FILES['News']) && isset($_FILES['News']['tmp_name']))
        {
            foreach ($_FILES['News']['tmp_name'] as $input=>$data)
            {
                if ($_FILES['News']['tmp_name'][$input] && preg_match('|^file_.+|', $input))
                {
                    $file = new NewsFile();
                    $file->material_id = $this->id;
                    $file->file = CUploadedFile::getInstance($this, $input);
                    $file->save();
                }
                unset($_FILES['News']['tmp_name'][$input]);
            }
        }
    }

    protected function beforeDelete()
    {
        $this->delFiles();
        return parent::beforeDelete();
    }    

    protected function delFiles()
    {
        foreach ($this->files as $file)
            $file->delete();
    }

    public function getAssocList($only_public = false)
    {
        $criteria = new CDbCriteria;
        if ($only_public)
            $criteria->addCondition('public=1');

        $criteria->select = 'id, title';
        $criteria->order ='date DESC';

        return CHtml::listData($this->findAll($criteria), 'id', 'title');
    }

    private $_url;

    public function getUrl()
    {
        if (!$this->page)
            return '';

        if ($this->_url === null)
            $this->_url = Yii::app()->createUrl('/new/new/show', array('path'=>$this->page->path, 'id'=>$this->id, 'alias'=>$this->alias));
        return $this->_url;
    }

    public function findByAlias($alias)
    {
        $model = $this->find(array(
            'condition'=>'alias = :alias',
            'params'=>array(':alias'=>$alias)
        ));
        return $model;
    }

    public function updateCommentsState($comment)
    {
        $comments_count = NewsComment::model()->material($this->id)->count('public=1');
        $comments_new_count = NewsComment::model()->material($this->id)->count('public=1 AND moder=0');

        $this->updateByPk($this->id, array('comments_count' => $comments_count));
        $this->updateByPk($this->id, array('comments_new_count' => $comments_new_count));
    }
}