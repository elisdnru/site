<?php

declare(strict_types=1);

namespace app\modules\comment\forms;

use yii\base\Model;

final class CommentForm extends Model
{
    public const SCENARIO_ANONIM = 'anonim';

    public ?string $name = null;
    public ?string $email = null;
    public ?string $site = null;
    public string $text = '';
    public ?string $parent_id = null;
    public string $yqe1 = '';
    public string $yqe2 = '';

    public function rules(): array
    {
        return [
            ['text', 'required', 'message' => 'Напишите текст комментария.'],
            ['parent_id', 'integer'],

            ['name', 'string', 'max' => 255],
            ['name', 'required', 'message' => 'Представьтесь, пожалуйста.', 'on' => self::SCENARIO_ANONIM],

            ['email', 'string', 'max' => 255],
            ['email', 'email', 'message' => 'Неверный формат E-mail адреса.'],
            ['email', 'required', 'message' => 'Введите Email', 'on' => self::SCENARIO_ANONIM],

            ['site', 'url'],
            ['site', 'string', 'max' => 255],

            ['yqe1', 'in', 'range' => [1], 'message' => 'Отметьте, что Вы человек.'],
            ['yqe2', 'in', 'range' => [0], 'message' => 'Вы уверены, что Вы бот?'],
        ];
    }

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
