<?php

declare(strict_types=1);

namespace app\modules\comment\forms;

use app\modules\comment\models\Comment;
use yii\base\Model;

class CommentEditForm extends Model
{
    public string $text;

    public function __construct(Comment $comment, array $config = [])
    {
        parent::__construct($config);
        $this->text = $comment->text;
    }

    public function rules(): array
    {
        return [
            ['text', 'required', 'message' => 'Напишите текст комментария.'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'text' => 'Комментарий',
        ];
    }
}
