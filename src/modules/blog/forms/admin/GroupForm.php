<?php

declare(strict_types=1);

namespace app\modules\blog\forms\admin;

use app\modules\blog\models\Group;
use Override;
use yii\base\Model;

final class GroupForm extends Model
{
    public string $title = '';

    /**
     * @param array<string, mixed> $config
     */
    public function __construct(?Group $group = null, array $config = [])
    {
        parent::__construct($config);

        if ($group !== null) {
            $this->title = $group->title;
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
            'title' => 'Наименование',
        ];
    }
}
