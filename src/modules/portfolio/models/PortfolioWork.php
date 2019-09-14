<?php

namespace app\modules\portfolio\models;

use app\components\module\DUrlRulesHelper;
use app\modules\blog\models\BlogPost;
use app\modules\main\components\helpers\DTextHelper;
use CActiveDataProvider;
use CActiveRecord;
use CDbCriteria;
use Yii;

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
 * @method PortfolioWork published()
 */
class PortfolioWork extends CActiveRecord
{
    const IMAGE_WIDTH = 250;
    const IMAGE_PATH = 'upload/images/portfolio';

    public $del_image = false;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className
     * @return BlogPost the static model class
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
        return '{{portfolio_work}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            ['date, category_id, alias, title', 'required'],
            ['sort, public, image_show', 'numerical', 'integerOnly' => true],
            ['category_id', \app\modules\main\components\DExistOrEmpty::class, 'className' => \app\modules\portfolio\models\PortfolioCategory::class, 'attributeName' => 'id'],
            ['short, text, description, del_image', 'safe'],
            ['date', 'date', 'format' => 'yyyy-MM-dd hh:mm:ss'],
            ['title, alias, pagetitle, keywords', 'length', 'max' => '255'],
            ['alias', 'match', 'pattern' => '#^\w[a-zA-Z0-9_-]+$#', 'message' => 'Допустимы только латинские символы, цифры и знак подчёркивания'],
            ['alias', 'unique', 'caseSensitive' => false, 'message' => 'Такой {attribute} уже используется'],
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
            'category' => [self::BELONGS_TO, \app\modules\portfolio\models\PortfolioCategory::class, 'category_id'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sort' => 'Порядок',
            'date' => 'Дата',
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
        ];
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.sort', $this->sort);
        $criteria->compare('t.date', $this->date, true);
        $criteria->compare('t.category_id', $this->category_id);
        $criteria->compare('t.alias', $this->alias, true);
        $criteria->compare('t.title', $this->title, true);
        $criteria->compare('t.pagetitle', $this->pagetitle, true);
        $criteria->compare('t.description', $this->description, true);
        $criteria->compare('t.keywords', $this->keywords, true);
        $criteria->compare('t.short', $this->short, true);
        $criteria->compare('t.text', $this->text, true);
        $criteria->compare('t.image', $this->image, true);
        $criteria->compare('t.image_show', $this->image_show);
        $criteria->compare('t.public', $this->public);

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
        ]);
    }

    public function scopes()
    {
        return [
            'published' => [
                'condition' => 't.public=1',
            ],
        ];
    }

    public function behaviors()
    {
        return [
            'PurifyShort' => [
                'class' => \app\modules\main\components\arbehaviors\DPurifyTextBehavior::class,
                'sourceAttribute' => 'short',
                'destinationAttribute' => 'short_purified',
                'purifierOptions' => [
                    'Attr.AllowedRel' => ['nofollow'],
                ],
                'processOnBeforeSave' => true,
            ],
            'PurifyText' => [
                'class' => \app\modules\main\components\arbehaviors\DPurifyTextBehavior::class,
                'sourceAttribute' => 'text',
                'destinationAttribute' => 'text_purified',
                'purifierOptions' => [
                    'Attr.AllowedRel' => ['nofollow'],
                    'HTML.SafeObject' => true,
                    'Output.FlashCompat' => true,
                ],
                'processOnBeforeSave' => true,
            ],
            'ImageUpload' => [
                'class' => \app\modules\uploader\components\DFileUploadBehavior::class,
                'fileAttribute' => 'image',
                'deleteAttribute' => 'del_image',
                'enableWatermark' => true,
                'filePath' => self::IMAGE_PATH,
                'defaultThumbWidth' => self::IMAGE_WIDTH,
                'imageWidthAttribute' => 'image_width',
                'imageHeightAttribute' => 'image_height',
            ],
            'PingBehavior' => [
                'class' => \app\modules\main\components\arbehaviors\DPingBehavior::class,
                'urlAttribute' => 'url',
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
            $this->alias = DTextHelper::strToChpu($this->title);
        }
        if (!$this->pagetitle) {
            $this->pagetitle = strip_tags($this->title);
        }
        if (!$this->description) {
            $this->description = strip_tags($this->short);
        }
    }

    protected function afterSave()
    {
        if (!$this->sort) {
            Yii::app()->db->createCommand('UPDATE ' . $this->tableName() . ' SET `sort`=`id` WHERE `id`=:id')->execute([':id' => $this->id]);
            $this->sort = $this->id;
        }
        parent::afterSave();
    }

    public function getAssocList($only_public = false)
    {
        if ($only_public) {
            $items = self::model()->published()->findAll(['order' => 'date DESC']);
        } else {
            $items = self::model()->findAll(['order' => 'date DESC']);
        }

        $result = [];

        foreach ($items as $item) {
            $result[$item['id']] = $item['title'];
        }

        return $result;
    }

    public function findByAlias($alias)
    {
        $model = $this->find([
            'condition' => 'alias = :alias',
            'params' => [':alias' => $alias]
        ]);
        return $model;
    }

    private $_url;

    public function getUrl()
    {
        if ($this->_url === null) {
            DUrlRulesHelper::import('portfolio');
            $this->_url = Yii::app()->createUrl('/portfolio/work/show', ['category' => $this->category->path, 'id' => $this->getPrimaryKey(), 'alias' => $this->alias]);
        }
        return $this->_url;
    }
}
