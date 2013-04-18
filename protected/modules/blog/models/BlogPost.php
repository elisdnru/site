<?php

Yii::import('application.modules.blog.models.*');
Yii::import('application.modules.user.models.User');
Yii::import('application.modules.gallery.models.Gallery');
Yii::import('application.modules.comment.components.DICommentDepends');

/**
 * This is the model class for table "{{new}}".
 *
 * The followings are the available columns in table '{{new}}':
 * @property integer $id
 * @property string $date
 * @property string $update_date
 * @property string $category_id
 * @property integer $author_id
 * @property string $alias
 * @property string $title
 * @property string $pagetitle
 * @property string $description
 * @property string $keywords
 * @property string $short
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
 *
 * @property string $url
 * @property string $imageUrl
 * @property string $imageThumdUrl
 *
 * @method BlogPost published()
 * @method BlogPost multilang()
 */

class BlogPost extends CActiveRecord implements DICommentDepends
{
    const IMAGE_WIDTH = 250;
    const IMAGE_PATH = 'upload/images/blogs';

	public $del_image = false;

    public $newgroup = '';

    protected $tags_string;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className
     * @return BlogPost the static model class
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
		return '{{blog_post}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('category_id, alias, title', 'required'),
            array('author_id', 'DExistOrEmpty', 'className' => 'User', 'attributeName' => 'id'),
            array('category_id', 'exist', 'className' => 'BlogCategory', 'attributeName' => 'id'),
            array('gallery_id', 'DExistOrEmpty', 'className' => 'Gallery', 'attributeName' => 'id'),
            array('group_id', 'DExistOrEmpty', 'className' => 'BlogPostGroup', 'attributeName' => 'id'),
			array('public, image_show, gallery_id', 'numerical', 'integerOnly'=>true),
			array('date', 'date', 'format'=>'yyyy-MM-dd hh:mm:ss'),
			array('short, text, description, del_image', 'safe'),
            array('title, alias, newgroup, image_alt, pagetitle, keywords', 'length', 'max'=>'255'),
            array('tagsString', 'length', 'max'=>'255'),
            array('alias', 'match', 'pattern' => '#^\w[a-zA-Z0-9_-]+$#', 'message' => 'Допустимы только латинские символы, цифры и знак подчёркивания'),
            array('alias', 'unique', 'caseSensitive' => false, 'message' => 'Такой {attribute} уже используется'),
            array('image','file','types'=>'jpg,jpeg,gif,png','allowEmpty'=>true,'safe'=>false),
            array('author_id', 'default', 'value'=>Yii::app()->user->id),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, date, category_id, author_id, title, pagetitle, description, keywords, image_alt, text, public, gallery_id', 'safe', 'on'=>'search'),
            //array('image', 'file', 'types'=>'jpg, gif, png'),
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
			'category' => array(self::BELONGS_TO, 'BlogCategory', 'category_id'),
			'author' => array(self::BELONGS_TO, 'User', 'author_id'),
			'gallery' => array(self::BELONGS_TO, 'Gallery', 'gallery_id'),
			'group' => array(self::BELONGS_TO, 'BlogPostGroup', 'group_id'),
            'posttags' => array(self::HAS_MANY, 'BlogPostTag', 'post_id'),
            'tags'=>array(self::MANY_MANY, 'BlogTag', '{{blog_post_tag}}(post_id, tag_id)', 'order'=>'tags.title'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'date' => 'Дата создания',
			'update_date' => 'Дата обновления',
			'category_id' => 'Раздел',
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
			'gallery_id' => 'Фотогалерея',
			'group_id' => 'Выберите тематическую группу',
			'newgroup' => '...или введите имя новой',
			'public' => 'Опубликовано',
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

        $criteria->compare('t.date',$this->date,true);
        $criteria->compare('t.update_date',$this->update_date,true);
        $criteria->compare('t.category_id',$this->category_id);
        $criteria->compare('t.author_id',$this->author_id);
        $criteria->compare('t.alias',$this->alias,true);
        $criteria->compare('t.title',$this->title,true);
        $criteria->compare('t.public',$this->public);
        $criteria->compare('t.group_id',$this->group_id);

        $criteria->with = array('category', 'author', 'group');

        return new CActiveDataProvider($this, array(
            'criteria'=>DMultilangHelper::enabled() ? $this->ml->modifySearchCriteria($criteria) : $criteria,
            'sort'=>array(
                'defaultOrder'=>'t.date DESC',
                'attributes'=>array(
                    'date',
                    'update_date',
                    'title',
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
                )
            ),
            'pagination'=>array(
                'pageSize'=>$pageSize,
                'pageVar'=>'page',
            ),
        ));
    }

    public function scopes()
    {
        return array(
            'published'=>array(
                'condition'=>'t.public=1 AND t.date <= NOW()',
            ),
        );
    }

    public function behaviors()
    {
        $behaviors = array(
            'CTimestampBehavior' => array(
                'class'=>'zii.behaviors.CTimestampBehavior',
                'setUpdateOnCreate'=>true,
                'createAttribute'=>'date',
                'updateAttribute'=>'update_date',
            ),
            'PurifyShort'=>array(
                'class'=>'DPurifyTextBehavior',
                'sourceAttribute'=>'short',
                'destinationAttribute'=>'short_purified',
                'purifierOptions'=> array(
                    'Attr.AllowedRel'=>array('nofollow'),
                ),
                'processOnBeforeSave'=>true,
            ),
            'PurifyText'=>array(
                'class'=>'DPurifyTextBehavior',
                'sourceAttribute'=>'text',
                'destinationAttribute'=>'text_purified',
                'enableMarkdown'=>true,
                'enablePurifier'=>true,
                'purifierOptions'=> array(
                    'Attr.AllowedRel'=>array('nofollow'),
                    'HTML.Nofollow' => true,
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
                        'short',
                        'short_purified',
                        'text',
                        'text_purified',
                        'pagetitle',
                        'description',
                        'keywords',
                    ),
                    'langClassName' => 'BlogPostLang',
                    'langTableName' => '{{blog_post_lang}}',
                    'languages' => Yii::app()->params['translatedLanguages'],
                    'defaultLanguage' => Yii::app()->params['defaultLanguage'],
                    'langForeignKey' => 'owner_id',
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
        if (!$this->alias) $this->alias = DTextHelper::strToChpu($this->title);
        if (!$this->pagetitle) $this->pagetitle = strip_tags($this->title);
        if (!$this->description) $this->description = strip_tags($this->short);

        parent::afterFind();
    }
    
    protected function beforeSave()
    {
        if (parent::beforeSave())
        {
            $this->processThematicGroup();

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
            $group = new BlogPostGroup();
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
        $this->updateTags();
        parent::afterSave();
    }

    public function getAssocList($only_public = false)
    {
        if ($only_public)
            $items = self::model()->published()->findAll(array('order'=>'date DESC'));
        else
            $items = self::model()->findAll(array('order'=>'date DESC'));

        $result = array();
        foreach ($items as $item)
            $result[$item['id']] = $item['title'];

        return $result;
    }

    public function findByAlias($alias)
    {
        return $this->findByAttributes(array('alias'=>$alias));
    }

    public function getTagsString()
    {
        if ($this->tags_string === null)
        {
            $list = CHtml::listData($this->cache(0)->tags, 'id', 'title');
            $this->tags_string = implode(', ', $list);
        }

        return $this->tags_string;
    }

    public function setTagsString($value)
    {
        $this->tags_string = $value;
    }

    public function updateTags()
    {
        $newtags = array_unique(preg_split('/\s*,\s*/', $this->tagsString));

        foreach ($this->posttags as $posttag)
            $posttag->delete();

        foreach ($newtags as $tagname)
        {
            $tag = BlogTag::model()->findOrCreateByTitle($tagname);

            $posttag = new BlogPostTag;
            $posttag->post_id = $this->id;
            $posttag->tag_id = $tag->id;
            $posttag->save();
        }
    }

    private $_url;

    public function getUrl(){
        if ($this->_url === null)
            $this->_url = Yii::app()->createUrl('/blog/post/show', array('id'=>$this->getPrimaryKey(), 'alias'=>$this->alias));
        return $this->_url;
    }

    public function updateCommentsState($comment)
    {
        $comments_count = BlogPostComment::model()->material($this->id)->count('public=1');
        $comments_new_count = BlogPostComment::model()->material($this->id)->count('public=1 AND moder=0');

        $this->updateByPk($this->id, array('comments_count' => $comments_count));
        $this->updateByPk($this->id, array('comments_new_count' => $comments_new_count));
    }
}