<?php

declare(strict_types=1);

namespace app\modules\blog\forms\admin;

use app\modules\blog\models\Group;
use yii\base\Model;

final class GroupForm extends Model
{
    public string $title = '';

    public function __construct(?Group $group = null, array $config = [])
    {
        parent::__construct($config);

        if ($group !== null) {
            $this->title = $group->title;
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
            'title' => 'Наименование',
        ];
    }
}
