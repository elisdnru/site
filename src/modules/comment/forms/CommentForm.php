<?php

namespace app\modules\comment\forms;

use CFormModel;

/**
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
    public function rules(): array
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            ['text', 'required', 'message' => 'Напишите текст комментария.'],
            ['parent_id', 'numerical', 'integerOnly' => true],

            ['name', 'length', 'max' => 255],
            ['name', 'required', 'message' => 'Представьтесь, пожалуйста.', 'on' => 'anonim'],

            ['email', 'length', 'max' => 255],
            ['email', 'email', 'message' => 'Неверный формат E-mail адреса.'],
            ['email', 'required', 'message' => 'Введите Email', 'on' => 'anonim'],

            ['site', 'url'],
            ['site', 'length', 'max' => 255],

            ['yqe1', 'in', 'range' => [1], 'message' => 'Отметьте, что Вы человек.'],
            ['yqe2', 'in', 'range' => [0], 'message' => 'Вы уверены, что Вы бот?'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels(): array
    {
        return [
            'name' => 'Ваше имя',
            'email' => 'Ваш Email',
            'site' => 'Ваш сайт',
            'text' => 'Комментарий',
            'yqe1' => 'Я – человек разумный',
            'yqe2' => 'Судью на мыло',
        ];
    }
}
