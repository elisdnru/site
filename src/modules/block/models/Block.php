<?php

declare(strict_types=1);

namespace app\modules\block\models;

use app\components\ForceActiveRecordErrors;
use Override;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $slug
 * @property string $title
 * @property string $text
 */
final class Block extends ActiveRecord
{
    use ForceActiveRecordErrors;

    #[Override]
    public static function tableName(): string
    {
        return 'blocks';
    }

    #[Override]
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'slug' => 'Псевдоним',
            'title' => 'Наименование',
            'text' => 'Содержимое',
        ];
    }
}
