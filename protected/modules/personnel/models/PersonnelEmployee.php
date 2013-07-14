<?php

Yii::import('application.modules.category.models.*');

/**
 * This is the model class for table "{{new}}".
 *
 * The followings are the available columns in table '{{new}}':
 * @property integer $id
 * @property string $sort
 * @property string $date
 * @property string $category_id
 * @property string $alias
 * @property string $title
 * @property string $pagetitle
 * @property string $description
 * @property string $keywords
 * @property string $short
 * @property string $text
 * @property string $image
 * @property integer $image_width
 * @property integer $image_height
 * @property integer $image_show
 * @property integer $public
 *
 * @property string $url
 * @property string $imageUrl
 * @property string $imageThumdUrl
 *
 * @method PersonnelEmployee published()
 * @method PersonnelEmployee multilang()
 */
class PersonnelEmployee extends CActiveRecord
{
    const IMAGE_WIDTH = 250;
    const IMAGE_PATH = 'upload/images/personnel';

	public $del_image = false;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className
     * @return PersonnelEmployee the static model class
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
		return '{{personnel_employee}}';
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
			array('sort, public, image_show', 'numerical', 'integerOnly'=>true),
            array('category_id', 'DExistOrEmpty', 'className' => 'PersonnelCategory', 'attributeName' => 'id'),
			array('short, text, description, del_image', 'safe'),
            array('title, alias, pagetitle, keywords', 'length', 'max'=>'255'),
            array('alias', 'match', 'pattern' => '#^\w[a-zA-Z0-9_-]+$#', 'message' => 'Допустимы только латинские символы, цифры и знак подчёркивания'),
            array('alias', 'unique', 'caseSensitive' => false, 'message' => 'Такой {attribute} уже используется'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, category_id, title, pagetitle, description, keywords, text, public', 'safe', 'on'=>'search'),
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
			'category' => array(self::BELONGS_TO, 'PersonnelCategory', 'category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'sort' => 'Порядок',
			'category_id' => 'Раздел',
			'title' => 'Заголовок',
			'alias' => 'URL транслитом',
			'pagetitle' => 'Заголовок страницы (title)',
			'description' => 'Описание (description)',
			'keywords' => 'Ключевые слова (keywords)',
			'short' => 'Превью',
			'text' => 'Текст',
			'image' => 'Картинка для статьи',
			'del_image' => 'Удалить изображение',
			'image_show' => 'Отображать при открытии',
			'public' => 'Опубликовано',
		);
	}

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('t.id',$this->id);
        $criteria->compare('t.sort',$this->sort);
        $criteria->compare('t.category_id',$this->category_id);
        $criteria->compare('t.alias',$this->alias,true);
        $criteria->compare('t.title',$this->title,true);
        $criteria->compare('t.pagetitle',$this->pagetitle,true);
        $criteria->compare('t.description',$this->description,true);
        $criteria->compare('t.keywords',$this->keywords,true);
        $criteria->compare('t.short',$this->short,true);
        $criteria->compare('t.text',$this->text,true);
        $criteria->compare('t.image',$this->image,true);
        $criteria->compare('t.image_show',$this->image_show);
        $criteria->compare('t.public',$this->public);

        return new CActiveDataProvider($this, array(
            'criteria'=>DMultilangHelper::enabled() ? $this->ml->modifySearchCriteria($criteria) : $criteria,
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
                'condition'=>'t.public=1',
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
                'enableWatermark'=>true,
                'filePath'=>self::IMAGE_PATH,
                'defaultThumbWidth'=>self::IMAGE_WIDTH,
                'imageWidthAttribute'=>'image_width',
                'imageHeightAttribute'=>'image_height',
            ),
            'PingBehavior'=>array(
                'class'=>'DPingBehavior',
                'urlAttribute'=>'url',
            ),
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
                    'langClassName' => 'PersonnelWorkLang',
                    'langTableName' => 'personnel_employee_lang',
                    'languages' => Yii::app()->params['translatedLanguages'],
                    'defaultLanguage' => Yii::app()->params['defaultLanguage'],
                    'langForeignKey' => 'owner_id',
                    'dynamicLangClass' => false,
                ),
            ));
        }

        return $behaviors;
    }

    protected function beforeSave()
    {
        if (parent::beforeSave())
        {
            if (!$this->alias)
                $this->alias = DTextHelper::strToChpu($this->title);

            if (!$this->pagetitle)
                $this->pagetitle = strip_tags($this->title);

            if (!$this->description)
                $this->description = strip_tags($this->short);

            return true;
        }
        return false;
    }

    protected function afterSave()
    {
        if (!$this->sort)
        {
            Yii::app()->db->createCommand('UPDATE ' . $this->tableName() . ' SET `sort`=`id` WHERE `id`=:id')->execute(array(':id'=>$this->id));
            $this->sort = $this->id;
        }
    }

    private $_url;

    public function getUrl()
    {
        if ($this->_url === null)
		{
			DUrlRulesHelper::import('personnel');
			$this->_url = Yii::app()->createUrl('/personnel/employee/show', array('category'=>$this->category->path, 'id'=>$this->getPrimaryKey(), 'alias'=>$this->alias));
		}
        return $this->_url;
    }
}