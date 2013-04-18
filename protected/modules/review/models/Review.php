<?php

/**
 * This is the model class for table "{{new}}".
 *
 * The followings are the available columns in table '{{new}}':
 * @property integer $id
 * @property string $date
 * @property integer $name
 * @property string $text
 * @property string $text_purified
 * @property integer $public
 * @property integer $moder
 * @property string $verifyCode
 */
class Review extends CActiveRecord
{
    public $verifyCode;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className
     * @return Review the static model class
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
		return '{{review}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, email, text', 'required'),
			array('public, moder', 'numerical', 'integerOnly'=>true),
            array('name, email', 'length', 'max'=>'255'),
            array('email', 'email', 'message' => 'Неверный формат E-mail адреса'),
            array('date, text', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, date, name, text, public, moder', 'safe', 'on'=>'search'),
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
			'name' => 'Автор',
			'email' => 'Email',
			'text' => 'Текст',
			'public' => 'Опубликован',
			'moder' => 'Просмотрен',
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
        $criteria->compare('t.name',$this->name);
        $criteria->compare('t.email',$this->email);
        $criteria->compare('t.text',$this->text,true);
        $criteria->compare('t.public',$this->public);
        $criteria->compare('t.moder',$this->moder);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'sort'=>array(
                'defaultOrder'=>'t.date DESC',
                'attributes'=>array(
                    'date',
                    'name',
                    'email',
                    'public',
                    'moder',
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
                'condition'=>'t.public=1',
            ),
        );
    }

    public function behaviors()
    {
        return array(
            'CategoryBehavior'=>array(
                'class'=>'category.components.DCategoryBehavior',
                'titleAttribute'=>'title',
                'defaultCriteria'=>array(
                    'order'=>'t.title ASC',
                ),
            ),
            'CTimestamp'=>array(
                'class'=>'zii.behaviors.CTimestampBehavior',
                'createAttribute'=>'date',
                'updateAttribute'=>null,
                'setUpdateOnCreate'=>false,
            ),
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
        );
    }

    private $_url;

    public function getUrl()
    {
        if ($this->_url === null)
        {
            DUrlRulesHelper::import('review');
            $this->_url = Yii::app()->createUrl('review/review/show', array('id'=>$this->getPrimaryKey()));
        }
        return $this->_url;
    }
}