<?php

/**
 * This is the model class for table "{{new}}".
 *
 * The followings are the available columns in table '{{new}}':
 * @property integer $id
 * @property integer $code
 * @property string $alias
 * @property string $title
 * @property string $short
 * @property string $short_purified
 * @property string $image
 * @property string $image_width
 * @property string $image_height
 * @property integer $free
 *
 * @property string $url
 * @property string $imageUrl
 * @property string $imageThumdUrl
 *
 * @method Book[] free()
 */
class Book extends CActiveRecord
{
    const IMAGE_WIDTH = 250;
    const IMAGE_PATH = 'upload/images/books';

	public $del_image = false;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className
     * @return Book the static model class
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
		return '{{booksru_book}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code, alias, title, author', 'required'),
			array('code, free', 'numerical', 'integerOnly'=>true),
            array('title, alias, author', 'length', 'max'=>'255'),
            array('short', 'safe'),
            array('alias', 'match', 'pattern' => '#^\w[a-zA-Z0-9_-]+$#', 'message' => 'Допустимы только латинские символы, цифры и знак подчёркивания'),
            array('alias', 'unique', 'caseSensitive' => false, 'message' => 'Такой {attribute} уже используется'),
            array('id, title, code, author, free', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'code' => 'Books.ru ID',
			'title' => 'Заголовок',
			'author' => 'Автор',
			'alias' => 'Псевдоним URL транслитом',
			'short' => 'Текст',
			'image' => 'Изображение',
			'del_image' => 'Удалить изображение',
			'free' => 'Свободная цена',
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
        $criteria->compare('code',$this->code,true);
        $criteria->compare('author',$this->author,true);
        $criteria->compare('alias',$this->alias,true);
        $criteria->compare('title',$this->title,true);
        $criteria->compare('short',$this->short,true);
        $criteria->compare('free',$this->free);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'sort'=>array(
                'defaultOrder'=>'t.id DESC',
                'attributes'=>array(
                    'code',
                    'alias',
                    'title',
                    'author',
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
            'free'=>array(
                'condition'=>'t.free = 1',
            ),
        );
    }

    public function behaviors()
    {
        return array(
            'PurifyShort'=>array(
                'class'=>'DPurifyTextBehavior',
                'sourceAttribute'=>'short',
                'destinationAttribute'=>'short_purified',
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
    }

    /**
     * @param $code
     * @return Book
     */
    public function findByCode($code)
    {
        $model = $this->find(array(
            'condition'=>'code = :code',
            'params'=>array(':code'=>$code)
        ));
        return $model;
    }

    /**
     * @param $alias
     * @return Book
     */
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
            DUrlRulesHelper::import('booksru');
            $this->_url = Yii::app()->createUrl('booksru/book/show', array('code'=>$this->code));
        }
        return $this->_url;
    }

    public function getOriginalUrl()
    {
        return 'http://www.books.ru/books/' . $this->alias . '/?show=1';
    }

    public function getPartnerUrl()
    {
        return 'http://www.books.ru/books/' . $this->alias . '/?show=1&partner=' . Yii::app()->config->get('BOOKSRU.PARTNER_ID');
    }
}