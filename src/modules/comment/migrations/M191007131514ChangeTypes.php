<?php

declare(strict_types=1);

namespace app\modules\comment\migrations;

use yii\db\Migration;

final class M191007131514ChangeTypes extends Migration
{
    public function safeUp(): bool
    {
        $this->update(
            'comments',
            ['type' => 'app\modules\blog\models\Post'],
            'type = :old_type',
            [':old_type' => 'app\modules\blog\models\BlogPost']
        );
        return true;
    }

    public function safeDown(): bool
    {
        $this->update(
            'comments',
            ['type' => 'app\modules\blog\models\BlogPost'],
            'type = :old_type',
            [':old_type' => 'app\modules\blog\models\Post']
        );
        return true;
    }
}
