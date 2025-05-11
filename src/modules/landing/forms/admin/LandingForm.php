<?php

declare(strict_types=1);

namespace app\modules\landing\forms\admin;

use app\components\SlugValidator;
use app\modules\landing\models\Landing;
use Override;
use yii\base\Model;

final class LandingForm extends Model
{
    public string $slug = '';
    public string $title = '';
    public string $text = '';
    public null|int|string $parent_id = null;
    public string $system = '';

    private ?Landing $landing = null;

    /**
     * @param array<string, mixed> $config
     */
    public function __construct(?Landing $landing = null, array $config = [])
    {
        parent::__construct($config);

        if ($landing !== null) {
            $this->slug = $landing->slug;
            $this->title = $landing->title;
            $this->text = $landing->text;
            $this->parent_id = $landing->parent_id;
            $this->system = (string)$landing->system;

            $this->landing = $landing;
        }
    }

    #[Override]
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

    #[Override]
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

    public function getAvailableParentList(): array
    {
        return $this->landing && $this->landing->parent_id
            ? array_diff_key(Landing::find()->getTabList(), Landing::find()->getAssocList($this->landing->id))
            : Landing::find()->getTabList();
    }
}
