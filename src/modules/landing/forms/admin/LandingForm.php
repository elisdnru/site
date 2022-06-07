<?php

declare(strict_types=1);

namespace app\modules\landing\forms\admin;

use app\components\SlugValidator;
use app\modules\landing\models\Landing;
use yii\base\Model;

final class LandingForm extends Model
{
    public string $slug = '';
    public string $title = '';
    public string $text = '';
    public string|int|null $parent_id = null;
    public string $system = '';

    public function __construct(?Landing $landing = null, array $config = [])
    {
        parent::__construct($config);

        if ($landing !== null) {
            $this->slug = $landing->slug;
            $this->title = $landing->title;
            $this->text = $landing->text;
            $this->parent_id = $landing->parent_id;
            $this->system = (string)$landing->system;
        }
    }

    public function rules(): array
    {
        return [
            [['slug', 'title'], 'required'],
            ['slug', SlugValidator::class],
            [['slug', 'title'], 'string', 'max' => 255],
            [['parent_id'], 'integer'],
            [['parent_id'], 'exist', 'targetClass' => Landing::class, 'targetAttribute' => 'id'],
            [['text', 'system'], 'safe'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'slug' => 'URL транслитом',
            'title' => 'Заголовок',
            'system' => 'Системный',
            'text' => 'Текст',
            'parent_id' => 'Родительский лендинг',
        ];
    }
}
