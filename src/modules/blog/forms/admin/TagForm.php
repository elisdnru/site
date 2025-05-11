<?php

declare(strict_types=1);

namespace app\modules\blog\forms\admin;

use app\modules\blog\models\Tag;
use Override;
use yii\base\Model;

final class TagForm extends Model
{
    public string $title = '';

    /**
     * @param array<string, mixed> $config
     */
    public function __construct(?Tag $tag = null, array $config = [])
    {
        parent::__construct($config);

        if ($tag !== null) {
            $this->title = $tag->title;
        }
    }

    #[Override]
    public function rules(): array
    {
        return [
            ['title', 'required'],
            ['title', 'string', 'max' => 255],
        ];
    }

    #[Override]
    public function attributeLabels(): array
    {
        return [
            'title' => 'Метка',
        ];
    }
}
