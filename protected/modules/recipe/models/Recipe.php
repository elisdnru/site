<?php

/**
 * This is the model class for table "{{new}}".
 *
 * The followings are the available columns in table '{{new}}':
 * @property integer $id
 * @property string $date
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
 * @property integer $gallery_id
 *
 * @property string $url
 * @property string $imageUrl
 * @property string $imageThumdUrl
 *
 * @method Recipe published()
 * @method Recipe multilang()
 */
class Recipe extends CActiveRecord
{

    const IMAGE_WIDTH = 250;
    const IMAGE_PATH = 'upload/images/recipes';

	public $del_image = false;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className
     * @return Recipe the static model class
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
		return '{{recipe}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date, alias, title', 'required'),
			array('gallery_id', 'numerical', 'integerOnly'=>true),
			array('date, short, text, description, del_image', 'safe'),
            array('title, alias, image_alt, pagetitle, keywords', 'length', 'max'=>'255'),
            array('alias', 'match', 'pattern' => '#^\w[a-zA-Z0-9_-]+$#', 'message' => 'Допустимы только латинские символы, цифры и знак подчёркивания'),
            array('alias', 'unique', 'caseSensitive' => false, 'message' => 'Такой {attribute} уже используется'),
            array('image','file','types'=>'jpg,jpeg,gif,png','allowEmpty'=>true,'safe'=>false),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, date, title, pagetitle, description, keywords, image_alt, text, gallery_id', 'safe', 'on'=>'search'),
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
			'gallery' => array(self::BELONGS_TO, 'Gallery', 'gallery_id'),
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
			'title' => 'Заголовок',
			'alias' => 'URL транслитом',
			'pagetitle' => 'Заголовок страницы (title)',
			'description' => 'Описание (description)',
			'keywords' => 'Ключевые слова (keywords)',
			'short' => 'Превью',
			'text' => 'Текст',
			'image' => 'Изображение',
			'del_image' => 'Удалить изображение',
			'image_alt' => 'Описание изображения (по умолчанию как заголовок)',
			'gallery_id' => 'Фотогалерея',
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
        $criteria->compare('date',$this->date,true);
        $criteria->compare('alias',$this->alias,true);
        $criteria->compare('title',$this->title,true);
        $criteria->compare('pagetitle',$this->pagetitle,true);
        $criteria->compare('description',$this->description,true);
        $criteria->compare('keywords',$this->keywords,true);
        $criteria->compare('short',$this->short,true);
        $criteria->compare('text',$this->text,true);
        $criteria->compare('image',$this->image,true);
        $criteria->compare('image_alt',$this->image_alt,true);
        $criteria->compare('gallery_id',$this->gallery_id);

        return new CActiveDataProvider($this, array(
            'criteria'=>DMultilangHelper::enabled() ? $this->ml->modifySearchCriteria($criteria) : $criteria,
            'sort'=>array(
                'defaultOrder'=>'t.date DESC',
                'attributes'=>array(
                    'date',
                    'alias',
                    'title',
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
                'condition'=>'t.date <= NOW()',
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
                ),
                'processOnBeforeSave'=>true,
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
                'filePath'=>self::IMAGE_PATH,
                'defaultThumbWidth'=>self::IMAGE_WIDTH,
                'imageWidthAttribute'=>'image_width',
                'imageHeightAttribute'=>'image_height',
            ),
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
                    'langClassName' => 'RecipeLang',
                    'langTableName' => 'recipe_lang',
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
        if (!$this->alias)
            $this->alias = DTextHelper::strToChpu($this->title);

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
            if (!$this->image_alt)
                $this->image_alt = $this->title;

            return true;
        }
        else
            return false;
    }

    public function findByAlias($alias)
    {
        $model = $this->find(array(
            'condition'=>'alias = :alias',
            'params'=>array(':alias'=>$alias)
        ));
        return $model;
    }

    private $_url;

    public function getUrl()
    {
        if ($this->_url === null)
        {
            DUrlRulesHelper::import('recipe');
            $this->_url = Yii::app()->createUrl('recipe/recipe/show', array('alias'=>$this->alias));
        }
        return $this->_url;
    }
}