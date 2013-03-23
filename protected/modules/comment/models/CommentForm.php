<?php

/**
 * This is the model class for table "{{comment}}".
 *
 * The followings are the available columns in table '{{comment}}':
 * @property string $user
 * @property string $text
 */
class CommentForm extends CFormModel
{
    public $name;
    public $email;
    public $site;
    public $text;
    public $parent_id;
    public $yqe1;
    public $yqe2;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('text', 'required', 'message' => 'Напишите текст комментария.'),
            array('parent_id', 'numerical', 'integerOnly'=>true),

            array('name', 'length', 'max'=>255),
            array('name', 'required', 'message' => 'Представьтесь, пожалуйста.', 'on'=>'anonim'),

            array('email', 'length', 'max'=>255),
            array('email', 'email', 'message' => 'Неверный формат E-mail адреса.'),
            array('email', 'required', 'message' => 'Введите Email', 'on'=>'anonim'),

            array('site', 'url'),
            array('site', 'length', 'max'=>255),

            array('yqe1', 'in', 'range'=>array(1), 'message' => 'Отметьте, что Вы человек.'),
            array('yqe2', 'in', 'range'=>array(0), 'message' => 'Вы уверены, что Вы бот?'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'name' => 'Ваше имя',
            'email' => 'Ваш Email',
            'site' => 'Ваш сайт',
            'text' => 'Комментарий',
            'yqe1' => 'Я – человек разумный',
            'yqe2' => 'Судью на мыло',
        );
    }
    
    protected function beforeValidate()
    {
        if ($this->site)
        {
            if (!preg_match('|^http:\/\/|', $this->site))
                $this->site = 'http://' . $this->site;

            if ($this->site == 'http://')
                $this->site = '';
        }
        
        return parent::beforeValidate();
    }
}