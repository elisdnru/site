<?php

declare(strict_types=1);

namespace app\modules\comment\migrations;

use yii\db\Migration;

/**
 * @psalm-api
 */
final class M190914202714ChangeTypes extends Migration
{
    public function safeUp(): bool
    {
        $this->update(
            '{{comment}}',
            ['type' => 'app\modules\blog\models\BlogPost'],
            'type = :old_type',
            [':old_type' => 'BlogPost']
        );
        return true;
    }

    public function safeDown(): bool
    {
        $this->update(
            '{{comment}}',
            ['type' => 'BlogPost'],
            'type = :old_type',
            [':old_type' => 'app\modules\blog\models\BlogPost']
        );
        return true;
    }
}
