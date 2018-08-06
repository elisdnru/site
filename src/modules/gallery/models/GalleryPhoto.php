<?php

Yii::import('application.modules.gallery.models.*');
Yii::import('application.modules.comment.components.DICommentDepends');

/**
 * This is the model class for table "{{gallery}}".
 *
 * The followings are the available columns in table '{{gallery}}':
 * @property integer $id
 * @property string $date
 * @property string $update_date
 * @property string $category_id
 * @property string $title
 * @property string $pagetitle
 * @property string $description
 * @property string $keywords
 * @property string $text
 * @property string $text_purified
 * @property string $image
 * @property string $image_width
 * @property string $image_height
 * @property string $image_alt
 * @property string $video
 * @property integer $public
 * @property integer $comments_count
 * @property integer $comments_new_count
 *
 * @property string $url
 * @property string $imageUrl
 * @property string $imageThumdUrl
 *
 * @method GalleryPhoto published()
 */
class GalleryPhoto extends CActiveRecord implements DICommentDepends
{
    const IMAGE_WIDTH = 250;
    const IMAGE_PATH = 'upload/images/galleries';

    public $del_image = false;

    public $newgroup = '';

    /**
     * Returns the static model of the specified AR class.
     * @param string $className
     * @return GalleryPhoto the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{gallery_photo}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            ['category_id', 'required'],
            ['category_id', 'exist', 'className' => 'GalleryCategory', 'attributeName' => 'id'],
            ['public', 'numerical', 'integerOnly' => true],
            ['date', 'date', 'format' => 'yyyy-MM-dd hh:mm:ss'],
            ['text, description, del_image', 'safe'],
            ['video', 'videoService', 'allowEmpty' => true],
            ['title, image_alt, pagetitle, keywords', 'length', 'max' => '255'],
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            ['id, date, category_id, title, pagetitle, description, keywords, text, public', 'safe', 'on' => 'search'],
        ];
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return [
            'category' => [self::BELONGS_TO, 'GalleryCategory', 'category_id'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Дата создания',
            'update_date' => 'Дата обновления',
            'category_id' => 'Раздел',
            'title' => 'Заголовок',
            'pagetitle' => 'Заголовок страницы (title)',
            'description' => 'Описание (description)',
            'keywords' => 'Ключевые слова (keywords)',
            'text' => 'Текст',
            'image' => 'Изображение',
            'video' => 'Видео',
            'del_image' => 'Удалить изображение',
            'image_alt' => 'Описание изображения (по умолчанию как заголовок)',
            'public' => 'Опубликовано',
        ];
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

        $criteria->compare('t.date', $this->date, true);
        $criteria->compare('t.update_date', $this->update_date, true);
        $criteria->compare('t.category_id', $this->category_id);
        $criteria->compare('t.title', $this->title, true);
        $criteria->compare('t.public', $this->public);

        $criteria->with = ['category'];

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
            'sort' => [
                'defaultOrder' => 't.date DESC',
                'attributes' => [
                    'date',
                    'update_date',
                    'title',
                    'category_id' => [
                        'asc' => 'category.title ASC',
                        'desc' => 'category.title DESC',
                    ],
                    'public',
                ]
            ],
            'pagination' => [
                'pageSize' => $pageSize,
                'pageVar' => 'page',
            ],
        ]);
    }

    public function scopes()
    {
        return [
            'published' => [
                'condition' => 't.public=1 AND t.date <= NOW()',
            ],
        ];
    }

    public function behaviors()
    {
        return [
            'CTimestampBehavior' => [
                'class' => 'zii.behaviors.CTimestampBehavior',
                'setUpdateOnCreate' => true,
                'createAttribute' => 'date',
                'updateAttribute' => 'update_date',
            ],
            'PurifyText' => [
                'class' => 'DPurifyTextBehavior',
                'sourceAttribute' => 'text',
                'destinationAttribute' => 'text_purified',
                'purifierOptions' => [
                    'HTML.SafeObject' => true,
                    'Output.FlashCompat' => true,
                ],
                'processOnBeforeSave' => true,
            ],
            'ImageUpload' => [
                'class' => 'uploader.components.DFileUploadBehavior',
                'fileAttribute' => 'image',
                'deleteAttribute' => 'del_image',
                'enableWatermark' => true,
                'filePath' => self::IMAGE_PATH,
                'defaultThumbWidth' => self::IMAGE_WIDTH,
                'imageWidthAttribute' => 'image_width',
                'imageHeightAttribute' => 'image_height',
            ],
        ];
    }

    public function videoService($attribute, $options)
    {
        if (!$this->$attribute && isset($options['allowEmpty']) && $options['allowEmpty']) {
            return;
        }

        if (preg_match('#https?:\/\/(www\.)?youtube\.com/(watch\?v=|v/)(?<id>[\w\d_-]+)([&\?][&\w\d=_-]+)?#i', $this->$attribute, $matches) ||
            preg_match('#https?:\/\/(www\.)?youtu.be/(?<id>[\w\d_-]+)(/?\?[&\w\d=_-]+)?#i', $this->$attribute, $matches)
        ) {
            $this->$attribute = 'http://www.youtube.com/v/' . $matches['id'];
            return;
        }

        $this->addError($attribute, 'Неподдерживаемый источник видео');
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
        if (!$this->pagetitle) {
            $this->pagetitle = strip_tags($this->title);
        }
        if (!$this->description) {
            $this->description = strip_tags($this->title);
        }
        if (!$this->image_alt) {
            $this->image_alt = strip_tags($this->title);
        }
    }

    private $_url;

    public function getUrl()
    {
        if ($this->_url === null) {
            DUrlRulesHelper::import('gallery');
            $this->_url = Yii::app()->createUrl('/gallery/photo/show', ['id' => $this->getPrimaryKey()]);
        }
        return $this->_url;
    }

    public function updateCommentsState($comment)
    {
        $comments_count = GalleryPhotoComment::model()->material($this->id)->count('public=1');
        $comments_new_count = GalleryPhotoComment::model()->material($this->id)->count('public=1 AND moder=0');

        $this->updateByPk($this->id, ['comments_count' => $comments_count]);
        $this->updateByPk($this->id, ['comments_new_count' => $comments_new_count]);
    }
}
