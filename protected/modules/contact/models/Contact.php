<?php

/**
 * This is the model class for table "{{contact}}".
 *
 * The followings are the available columns in table '{{contact}}':
 * @property integer $id
 * @property string $pagetitle
 * @property string $date
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $text
 * @property string $file
 * @property string $label
 * @property string $status
 */
class Contact extends CActiveRecord
{
    const STATUS_NEW = 0;
    const STATUS_READED = 1;

	/**
	 * Returns the static model of the specified AR class.
	 * @return Contact the static model class
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
		return '{{contact}}';
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
			array('name', 'length', 'max'=>200),
			array('email, phone', 'length', 'max'=>100),
            array('email', 'email'),
			array('date, status', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, pagetitle, date, name, email, phone, text, label, status', 'safe', 'on'=>'search')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'pagetitle' => 'Со страницы',
			'date' => 'Дата',
			'name' => 'Имя',
			'email' => 'Email',
			'phone' => 'Телефон',
			'text' => 'Текст',
			'label' => 'Примечание',
			'status' => 'Прочитано',
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
		$criteria->compare('t.pagetitle',$this->pagetitle,true);
		$criteria->compare('t.date',$this->date,true);
		$criteria->compare('t.name',$this->name,true);
		$criteria->compare('t.email',$this->email,true);
		$criteria->compare('t.phone',$this->phone,true);
		$criteria->compare('t.text',$this->text,true);
		$criteria->compare('t.label',$this->label,true);
		$criteria->compare('t.status',$this->status,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'sort'=>array(
                'defaultOrder'=>'t.date DESC, t.id DESC',
                'attributes'=>array(
                    'date'=>array(
                        'asc'=>'t.date ASC',
                        'desc'=>'t.date DESC',
                    ),
                    'pagetitle',
                    'name',
                    'email',
                    'text',
                    'status',
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
            $email->subject = 'Сообщение №'.$this->id.' на сайте '.$_SERVER['SERVER_NAME'];
            $email->message = '';
            $email->view = 'contact';
            $email->viewVars = array(
                'contact'=>$this,
            );
            $email->send();
        }
    }
}