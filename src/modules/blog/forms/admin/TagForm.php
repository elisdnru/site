<?php

declare(strict_types=1);

namespace app\modules\blog\forms\admin;

use app\modules\blog\models\Tag;
use yii\base\Model;

final class TagForm extends Model
{
    public string $title = '';

    public function __construct(?Tag $tag = null, array $config = [])
    {
        parent::__construct($config);

        if ($tag !== null) {
            $this->title = $tag->title;
        }
    }

    public function rules(): array
    {
        return [
            ['title', 'required'],
            ['title', 'string', 'max' => 255],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'title' => 'Метка',
        ];
    }
}
