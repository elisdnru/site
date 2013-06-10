<?php

/**
 * This is the model class for table "{{new}}".
 *
 * The followings are the available columns in table '{{new}}':
 * @property integer $id
 * @property integer $sort
 * @property string $title
 * @property string $text
 * @property string $text_purified
 * @property string $image
 * @property string $url
 * @property string $imageUrl
 * @property string $imageThumdUrl
 */
class Slide extends CActiveRecord
{
    const IMAGE_WIDTH = 250;
    const IMAGE_PATH = 'upload/images/slides';

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
		return '{{slideshow}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, url', 'required'),
			array('sort', 'numerical', 'integerOnly'=>true),
			array('text', 'safe'),
            array('title, url', 'length', 'max'=>'255'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, title, text, url', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'sort' => 'Позиция',
			'title' => 'Заголовок',
			'text' => 'Текст',
			'image' => 'Изображение',
			'url' => 'Ссылка',
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
        $criteria->compare('sort',$this->sort);
        $criteria->compare('title',$this->title,true);
        $criteria->compare('text',$this->text,true);
        $criteria->compare('image',$this->image,true);
        $criteria->compare('url',$this->url,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'sort'=>array(
                'defaultOrder'=>'t.sort DESC',
                'attributes'=>array(
                    'title',
                    'sort',
                    'url',
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
            'ImageUpload'=>array(
                'class'=>'uploader.components.DFileUploadBehavior',
                'fileAttribute'=>'image',
                'filePath'=>self::IMAGE_PATH,
                'defaultThumbWidth'=>self::IMAGE_WIDTH,
            ),
        );
    }

    protected function beforeValidate()
    {
        if (parent::beforeValidate())
        {
            $this->url = str_replace(Yii::app()->request->hostInfo, '', $this->url);
            if (empty($this->url))
                $this->url = '/';

			return true;
        }
		return false;
    }
}