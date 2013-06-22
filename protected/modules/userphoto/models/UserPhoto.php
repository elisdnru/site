<?php

Yii::import('application.modules.user.models.*');
Yii::import('application.modules.comment.models.*');
Yii::import('application.modules.userphoto.models.*');

/**
 * This is the model class for table "{{shop_image}}".
 *
 * The followings are the available columns in table '{{shop_image}}':
 * @property string $id
 * @property integer $user_id
 * @property string $title
 * @property string $text
 * @property string $file
 */
class UserPhoto extends CActiveRecord
{
    const IMAGE_WIDTH = 250;
    const IMAGE_PATH = 'upload/images/users/galleries';

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserPhoto the static model class
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
		return '{{user_photo}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, title', 'required'),
			array('user_id', 'unsafe'),
			array('text', 'safe'),
			array('title', 'length', 'max'=>255),
			array('id, user_id, file', 'safe', 'on'=>'search'),
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
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'Пользователь',
			'title' => 'Название',
			'text' => 'Текст',
			'file' => 'Изображение',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
    public function search($pageSize=10)
    {
        $criteria=new CDbCriteria;

        $criteria->compare('t.id',$this->id,true);
        $criteria->compare('t.user_id',$this->user_id);
        $criteria->compare('t.title',$this->title,true);
        $criteria->compare('t.text',$this->title,true);
        $criteria->compare('t.file',$this->file,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'sort'=>array(
                'defaultOrder'=>'t.id DESC',
                'attributes'=>array(
                    'id',
                    'user_id',
                    'title',
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
            'PurifyText'=>array(
                'class'=>'DPurifyTextBehavior',
                'sourceAttribute'=>'text',
                'destinationAttribute'=>'text_purified',
                'purifierOptions'=> array(
                    'AutoFormat.AutoParagraph' => true,
                    'HTML.Allowed' => 'p,ul,li,b,i,a[href],pre',
                    'AutoFormat.Linkify' => true,
                    'HTML.Nofollow' => true,
                    'Core.EscapeInvalidTags' => true,
                ),
                'processOnBeforeSave'=>true,
            ),
            'ImageUpload'=>array(
                'class'=>'uploader.components.DFileUploadBehavior',
                'fileAttribute'=>'file',
                'storageAttribute'=>'file',
                'deleteAttribute'=>null,
                'enableWatermark'=>true,
                'filePath'=>self::IMAGE_PATH,
            ),
            'PingBehavior'=>array(
                'class'=>'DPingBehavior',
                'urlAttribute'=>'url',
            ),
        );
    }

    /**
     * scope
     * @param $user_id
     * @return UserPhoto
     */
    public function user($user_id)
    {
        if ($user_id)
        {
            $this->getDbCriteria()->mergeWith(array(
                'condition' => 't.user_id=:id',
                'params'=>array(':id'=>$user_id),
            ));
        }
        return $this;
    }

    private $_url;

    public function getUrl()
    {
        if ($this->_url === null)
		{
			DUrlRulesHelper::import('userphoto');
			$this->_url = Yii::app()->createUrl('/userphoto/photo/view', array('id'=>$this->getPrimaryKey()));
		}
        return $this->_url;
    }

    protected function afterDelete()
    {
        Comment::model()->deleteAllByAttributes(array(
            'material_id'=>$this->id,
            'type'=>UserPhotoComment::TYPE_OF_COMMENT,
        ));
    }
}