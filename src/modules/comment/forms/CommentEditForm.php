<?php

declare(strict_types=1);

namespace app\modules\comment\forms;

use app\modules\comment\models\Comment;
use Override;
use yii\base\Model;

final class CommentEditForm extends Model
{
    public string $text;

    /**
     * @param array<string, mixed> $config
     */
    public function __construct(Comment $comment, array $config = [])
    {
        parent::__construct($config);
        $this->text = $comment->text;
    }

    #[Override]
    public function rules(): array
    {
        return [
            ['text', 'required', 'message' => 'Напишите текст комментария.'],
        ];
    }

    #[Override]
    public function attributeLabels(): array
    {
        return [
            'text' => 'Комментарий',
        ];
    }
}
