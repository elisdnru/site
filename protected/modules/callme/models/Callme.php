<?php

/**
 * This is the model class for table "{{contact}}".
 *
 * The followings are the available columns in table '{{contact}}':
 * @property integer $id
 * @property string $date
 * @property string $name
 * @property string $tel
 * @property string $text
 * @property int $readed
 * @property int $called
 */
class Callme extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Callme the static model class
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
		return '{{callme}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tel', 'required'),
			array('name', 'length', 'max'=>200),
			array('tel', 'length', 'max'=>100),
            array('text', 'safe'),
			array('date, readed, called', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, date, name, tel, text, readed, called', 'safe', 'on'=>'search')
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
			'name' => 'Имя',
			'tel' => 'Телефон',
			'text' => 'Текст',
			'readed' => 'Прочитано',
			'called' => 'Звонок произведён',
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
		$criteria->compare('t.name',$this->name,true);
		$criteria->compare('t.tel',$this->tel,true);
		$criteria->compare('t.text',$this->text,true);
		$criteria->compare('t.readed',$this->readed,true);
		$criteria->compare('t.called',$this->called,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'sort'=>array(
                'defaultOrder'=>'t.date DESC, t.id DESC',
                'attributes'=>array(
                    'date'=>array(
                        'asc'=>'t.date ASC',
                        'desc'=>'t.date DESC',
                    ),
                    'name',
                    'tel',
                    'text',
                    'readed',
                    'called',
                )
            ),
            'pagination'=>array(
                'pageSize'=>$pageSize,
                'pageVar'=>'page',
            ),
        ));
	}

    protected function beforeSave()
    {
        if ($this->isNewRecord)
            $this->date = date('Y-m-d H:i:s');

        return parent::beforeSave();
    }

    public function sendEmail()
    {
        if (Yii::app()->config->get('MAIL.SEND_EMAILS'))
        {
            $email = Yii::app()->email;
            $email->to = Yii::app()->config->get('MAIL.ADMIN_EMAIL');
            $email->replyTo = $this->name.' <'.$this->email.'>';
            $email->subject = 'Заказ звонка №'.$this->id.' на сайте '.$_SERVER['SERVER_NAME'];
            $email->message = '';
            $email->view = 'callme';
            $email->viewVars = array(
                'callme'=>$this,
            );
            $email->send();
        }
    }
}