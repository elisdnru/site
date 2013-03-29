<?php

/**
 * This is the model class for table "{{shop_order}}".
 *
 * The followings are the available columns in table '{{shop_order}}':
 * @property integer $id
 * @property string $date
 * @property integer $user_id
 * @property string $lastname
 * @property string $name
 * @property string $middlename
 * @property string $zip
 * @property string $address
 * @property string $phone
 * @property string $email
 * @property string $comment
 * @property string $quickly
 * @property integer $complete
 * @property integer $apply
 * @property integer $payed
 * @property integer $post
 * @property integer $post_title
 * @property integer $post_sum
 * @property integer $post_code
 * @property integer $curs
 */
class ShopOrder extends CActiveRecord
{
    const FILE_PATH = 'upload/files/orders';

    public $post;
    public $confirm;

    protected $old_complete;
    protected $old_apply;
    protected $old_payed;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ShopOrder the static model class
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
		return '{{shop_order}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, post_id, lastname, name, phone, email, zip, address', 'required'),
			array('confirm', 'numerical', 'min'=>1, 'tooSmall'=>'Для осуществления заказа необходимо согласиться с правилами', 'on'=>'orderForm'),
			array('user_id, post_id, quickly', 'numerical', 'integerOnly'=>true),
			array('lastname, name, middlename, zip, phone, email, post_code', 'length', 'max'=>255),
            array('email', 'email', 'message' => 'Неверный формат E-mail адреса'),
			array('address, date, comment', 'safe'),
			array('curs', 'unsafe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, date, user_id, post_id, lastname, name, middlename, fio, address, zip, phone, quickly, complete, curs, apply, payed, complete', 'safe', 'on'=>'search'),
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
            'products' => array(self::HAS_MANY, 'ShopOrderProduct', 'order_id'),
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
			'date' => 'Дата',
			'user_id' => 'User',
			'lastname' => 'Фамилия',
			'name' => 'Имя',
			'middlename' => 'Отчество',
			'fio' => 'Заказчик',
			'zip' => 'Потовый индекс',
			'address' => 'Адрес',
			'phone' => 'Телефон',
			'email' => 'Email',
			'comment' => 'Комментарий к заказу',
			'complete' => 'Завершён',
			'apply' => 'Принят',
			'payed' => 'Оплачен',
			'post_id' => 'Способ доставки',
			'post_title' => 'Способ доставки',
			'post_code' => 'Идентификатор отправления',
			'confirm' => 'Я согласен с условиями',
			'quickly' => 'Отправить срочно',
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
        $criteria->compare(new CDbExpression("CONCAT(t.lastname, ' ', t.name, ' ', t.middlename)"), $this->fio, true);
        $criteria->compare('t.lastname',$this->lastname,true);
		$criteria->compare('t.name',$this->name,true);
		$criteria->compare('t.middlename',$this->middlename,true);
		$criteria->compare('t.zip',$this->zip,true);
		$criteria->compare('t.address',$this->address,true);
		$criteria->compare('t.phone',$this->phone,true);
		$criteria->compare('t.email',$this->email,true);
		$criteria->compare('t.quickly',$this->quickly,true);
		$criteria->compare('t.complete',$this->complete);
		$criteria->compare('t.payed',$this->payed);
		$criteria->compare('t.apply',$this->apply);

        $criteria->with = array('user');

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'sort'=>array(
                'defaultOrder'=>'t.date DESC',
                'attributes'=>array(
                    'id',
                    'date',
                    'email',
                    'phone',
                    'fio'=>array(
                        'asc'=>'t.lastname ASC, t.name ASC, t.middlename ASC',
                        'desc'=>'t.lastname DESC, t.name DESC, t.middlename DESC',
                    ),
                    'apply',
                    'payed',
                    'complete',
                    'quickly',
                )
            ),
            'pagination'=>array(
                'pageSize'=>$pageSize,
                'pageVar'=>'page',
            ),
        ));
	}

    protected function afterFind()
    {
        $this->old_complete = $this->complete;
        $this->old_apply = $this->apply;
        $this->old_payed = $this->payed;
        parent::afterFind();
    }

    protected function beforeSave()
    {
        if (parent::beforeSave())
        {
            if ($this->post_id && $post = ShopPostType::model()->findByPk($this->post_id))
            {
                $this->post_title = $post->title;
                $this->post_sum = $post->summ;
            }
            return true;
        }
        return false;
    }

    protected function afterSave()
    {
        if (!$this->isNewRecord)
            $this->processOrder();

        parent::afterSave();
    }

    protected function beforeDelete()
    {
        foreach ($this->products as $product)
            $product->delete();

        return parent::beforeDelete();
    }

    public function sendEmails()
    {
        $this->sendAdminEmail();
        $this->sendClientEmail();
    }

    public function sendAdminEmail($attach = false)
    {
        if (Yii::app()->config->get('MAIL.SEND_EMAILS'))
        {
            $mailer = Yii::app()->mailer;
            $mailer->reset();
            $mailer->AddReplyTo($this->email);
            $mailer->AddAddress(Yii::app()->config->get('GENERAL.ADMIN_EMAIL'));
            $mailer->CharSet = 'UTF-8';
            $mailer->IsHTML();
            $mailer->Subject = 'Новый заказ №' . $this->getFullId() . ' на сайте '.$_SERVER['SERVER_NAME'];
            $mailer->Body = 'Новый заказ';
            $mailer->getView('order/order', array(
                'order'=>$this,
            ));

            if ($attach)
                $mailer->AddAttachment($attach);

            $mailer->Send();

        }
    }

    public function sendClientEmail($attach = false)
    {
        $mailer = Yii::app()->mailer;
        $mailer->reset();
        $mailer->AddReplyTo(Yii::app()->config->get('GENERAL.ADMIN_EMAIL'));
        $mailer->AddAddress($this->email);
        $mailer->CharSet = 'UTF-8';
        $mailer->IsHTML();
        $mailer->Subject = 'Ваш заказ №' . $this->getFullId() . ' на сайте '.$_SERVER['SERVER_NAME'];
        $mailer->Body = 'Ваш заказ';
        $mailer->getView('order/client', array(
            'order'=>$this,
        ));

        $mailer->Send();
    }

    protected  function processOrder()
    {
        if ($this->complete != $this->old_complete)
        {
            foreach ($this->products as $orderproduct)
            {
                if ($orderproduct->product)
                {
                    $orderproduct->product->count += ($this->complete ? -1 : 1)*$orderproduct->count;
                    $orderproduct->product->save();
                }
            }

            if ($this->complete)
                $this->sendUserNotification('order/complete');
            else
                $this->sendUserNotification('order/uncomplete');

        }

        if ($this->apply != $this->old_apply)
        {
            if ($this->apply)
                $this->sendUserNotification('order/apply');
            else
                $this->sendUserNotification('order/unapply');
        }

        if ($this->payed != $this->old_payed)
        {
            if ($this->payed)
                $this->sendUserNotification('order/payed');
            else
                $this->sendUserNotification('order/unpayed');
        }
    }

    protected  function sendUserNotification($view)
    {
        $email = Yii::app()->email;
        $email->to = $this->email;
        $email->replyTo = Yii::app()->config->get('GENERAL.ADMIN_EMAIL');
        $email->subject = 'Новый статус заказа №'.$this->getFullId().' на сайте '.$_SERVER['SERVER_NAME'];
        $email->message = '';
        $email->view = $view;
        $email->viewVars = array(
            'order'=>$this,
        );
        $email->send();
    }
    
    private $_fullid;

    public function getFullId()
    {
        if ($this->_fullid === null)
            $this->_fullid = $this->id;

        return $this->_fullid;
    }

    private $_fullAddress;

    public function getFullAddress()
    {
        if ($this->_fullAddress === null)
            $this->_fullAddress = ($this->zip ? $this->zip . ', ' : '') . $this->address;

        return $this->_fullAddress;
    }

    public function getFullSumm()
    {
        $summ = 0;

        foreach ($this->products as $product)
            $summ += $product->count * $product->price;

        return $summ;
    }

    private $_fio;

    public function getFio()
    {
        if ($this->_fio === null)
            $this->_fio = trim($this->lastname.' '.$this->name.' '.$this->middlename);

        return $this->_fio;
    }

    public function setFio($value)
    {
        $this->_fio = $value;
    }


    public function onPaymentSuccess(CEvent $event)
    {
        $id = $event->params['order']->id;
        $this->updateByPk($id, array('payed'=>1));
    }
}