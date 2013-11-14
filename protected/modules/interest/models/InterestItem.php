<?php

/**
 * This is the model class for table "{{interest_item}}".
 *
 * The followings are the available columns in table '{{interest_item}}':
 * @property integer $id
 * @property string $link
 * @property string $title
 * @property string $author
 * @property string $short
 * @property string $short_purified
 * @property string $image
 * @property string $image_width
 * @property string $image_height
 *
 * @property string $url
 * @property string $imageUrl
 * @property string $imageThumdUrl
 */
class InterestItem extends CActiveRecord
{
    const IMAGE_WIDTH = 250;
    const IMAGE_PATH = 'upload/images/interests';

	public $del_image = false;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className
     * @return InterestItem the static model class
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
		return '{{interest_item}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('link, title, author', 'required'),
            array('link, title, author', 'length', 'max'=>'255'),
            array('short', 'safe'),
            array('id, link, author, title', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'link' => 'URL',
			'title' => 'Заголовок',
			'author' => 'Автор',
			'short' => 'Текст',
			'image' => 'Изображение',
			'del_image' => 'Удалить изображение',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @param int $pageSize
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
    public function search($pageSize=10)
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('link',$this->link,true);
        $criteria->compare('author',$this->author,true);
        $criteria->compare('title',$this->title,true);
        $criteria->compare('short',$this->short,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'sort'=>array(
                'defaultOrder'=>'t.id DESC',
                'attributes'=>array(
                    'id',
                    'link',
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

    private $_url;

    public function getUrl()
    {
        if ($this->_url === null)
        {
            DUrlRulesHelper::import('interest');
            $this->_url = Yii::app()->createUrl('interest/item/show', array('id'=>$this->id));
        }
        return $this->_url;
    }

    public function getPartnerUrl()
    {
        return $this->link;
    }
}