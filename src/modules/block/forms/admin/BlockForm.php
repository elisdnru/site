<?php

declare(strict_types=1);

namespace app\modules\block\forms\admin;

use app\components\SlugValidator;
use app\modules\block\models\Block;
use Override;
use yii\base\Model;

final class BlockForm extends Model
{
    public string $slug = '';
    public string $title = '';
    public string $text = '';

    private ?int $id = null;

    public function __construct(?Block $block = null, array $config = [])
    {
        parent::__construct($config);

        if ($block !== null) {
            $this->id = $block->id;
            $this->slug = $block->slug;
            $this->title = $block->title;
            $this->text = $block->text;
        }
    }

    #[Override]
    public function rules(): array
    {
        return [
            [['slug', 'title'], 'required'],
            [['slug', 'title'], 'string', 'max' => 255],
            ['slug', SlugValidator::class],
            ['slug', 'unique', 'targetClass' => Block::class, 'filter' => ['!=', 'id', $this->id]],
            [['text', 'short'], 'safe'],
        ];
    }

    #[Override]
    public function attributeLabels(): array
    {
        return [
            'slug' => 'Псевдоним',
            'title' => 'Наименование',
            'text' => 'Содержимое',
        ];
    }
}
