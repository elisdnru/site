<?php

declare(strict_types=1);

namespace app\modules\comment\forms\admin;

use app\modules\comment\models\Comment;
use yii\base\Model;

class CommentUpdateForm extends Model
{
    public string $date;
    public null|string $name;
    public string $email;
    public null|string $site;
    public string $text;
    public null|int|string $parent_id;

    private null|int $user_id;

    final public function __construct(Comment $comment, array $config = [])
    {
        parent::__construct($config);

        $this->date = $comment->date;
        $this->name = $comment->name;
        $this->email = $comment->email;
        $this->site = $comment->site;
        $this->text = $comment->text;
        $this->parent_id = $comment->parent_id;
        $this->user_id = $comment->user_id;
    }

    public function rules(): array
    {
        $anon = static fn (self $model): bool => !$model->user_id;

        return [
            [['text'], 'required'],
            [['parent_id'], 'integer'],

            ['name', 'required', 'message' => 'Представьтесь', 'when' => $anon],
            ['name', 'string', 'max' => 255, 'when' => $anon],

            ['email', 'required', 'message' => 'Введите Email', 'when' => $anon],
            ['email', 'string', 'max' => 255, 'when' => $anon],
            ['email', 'email', 'when' => $anon],

            ['site', 'url', 'when' => $anon],
            ['site', 'string', 'max' => 255, 'when' => $anon],

            ['text', $this->fixedText(...)],
        ];
    }

    public function fixedText(string $attribute): void
    {
        $value = trim((string)$this->{$attribute});
        $value = preg_replace('#\r\n#', "\n", $value);
        $value = preg_replace('#([^\n])\n?<pre>#', "$1\n\n<pre>", $value);
        $this->{$attribute} = $value;
    }

    public function attributeLabels(): array
    {
        return [
            'parent_id' => 'ID родителя',
            'date' => 'Дата',
            'name' => 'Имя',
            'email' => 'Email',
            'site' => 'Сайт',
            'text' => 'Текст',
        ];
    }
}
