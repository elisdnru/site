<?php

namespace app\modules\contact\models;

use RuntimeException;
use Yii;
use yii\db\ActiveRecord;

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
class Contact extends ActiveRecord
{
    public const STATUS_NEW = 0;
    public const STATUS_READED = 1;

    public static function tableName(): string
    {
        return 'contacts';
    }

    public function rules(): array
    {
        return [
            [['name', 'email', 'text'], 'required'],
            ['name', 'string', 'max' => 200],
            [['email', 'phone'], 'string', 'max' => 100],
            ['email', 'email'],
            [['date', 'status'], 'safe'],
        ];
    }

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

    public function beforeSave($insert): bool
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->date = date('Y-m-d H:i:s');
            }
            return true;
        }
        return false;
    }

    public function afterSave($insert, $changedAttributes): void
    {
        if ($insert) {
            $this->sendAdminNotify();
        }

        parent::afterSave($insert, $changedAttributes);
    }

    private function sendAdminNotify(): void
    {
        $mail = Yii::$app->mailer
            ->compose(['html' => 'contact'], [
                'contact' => $this,
            ])
            ->setSubject('Сообщение №' . $this->id . ' на сайте elisdn.ru')
            ->setTo(Yii::$app->params['GENERAL.ADMIN_EMAIL'])
            ->setReplyTo([$this->email => $this->name]);

        if (!$mail->send()) {
            throw new RuntimeException('Unable to send contact message ' . $this->id);
        }
    }
}
