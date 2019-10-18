<?php

namespace app\modules\contact\models;

use CActiveDataProvider;
use CActiveRecord;
use CDbCriteria;
use Yii;

/**
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
     * @param string|null $className
     * @return CActiveRecord|static
     */
    public static function model($className = null): self
    {
        return parent::model($className ?: static::class);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName(): string
    {
        return 'contacts';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules(): array
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            ['name, email, text', 'required'],
            ['name', 'length', 'max' => 200],
            ['email, phone', 'length', 'max' => 100],
            ['email', 'email'],
            ['date, status', 'safe'],
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            ['id, pagetitle, date, name, email, phone, text, label, status', 'safe', 'on' => 'search']
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'pagetitle' => 'Со страницы',
            'date' => 'Дата',
            'name' => 'Имя',
            'email' => 'Email',
            'phone' => 'Телефон',
            'text' => 'Текст',
            'label' => 'Примечание',
            'status' => 'Прочитано',
        ];
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @param int $pageSize
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($pageSize = 10): CActiveDataProvider
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.pagetitle', $this->pagetitle, true);
        $criteria->compare('t.date', $this->date, true);
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('t.email', $this->email, true);
        $criteria->compare('t.phone', $this->phone, true);
        $criteria->compare('t.text', $this->text, true);
        $criteria->compare('t.label', $this->label, true);
        $criteria->compare('t.status', $this->status, true);

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
            'sort' => [
                'defaultOrder' => 't.date DESC, t.id DESC',
                'attributes' => [
                    'date' => [
                        'asc' => 't.date ASC',
                        'desc' => 't.date DESC',
                    ],
                    'pagetitle',
                    'name',
                    'email',
                    'text',
                    'status',
                ]
            ],
            'pagination' => [
                'pageSize' => $pageSize,
                'pageVar' => 'page',
            ],
        ]);
    }

    protected function beforeSave(): bool
    {
        if (parent::beforeSave()) {
            if ($this->isNewRecord) {
                $this->date = date('Y-m-d H:i:s');
            }
            return true;
        }
        return false;
    }

    protected function afterSave(): void
    {
        if ($this->isNewRecord) {
            $this->sendAdminNotify();
        }

        parent::afterSave();
    }

    private function sendAdminNotify(): void
    {
        $mail = Yii::$app->mailer
            ->compose(['html' => 'contact'], [
                'contact' => $this,
            ])
            ->setSubject('Сообщение №' . $this->id . ' на сайте elisdn.ru')
            ->setTo(Yii::app()->params['GENERAL.ADMIN_EMAIL'])
            ->setReplyTo([$this->email => $this->name]);

        if (!$mail->send()) {
            throw new \RuntimeException('Unable to send contact message ' . $this->id);
        }
    }
}
