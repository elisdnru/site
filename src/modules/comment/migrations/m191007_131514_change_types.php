<?php

use yii\db\Migration;

class m191007_131514_change_types extends Migration
{
    public function safeUp(): bool
    {
        $this->update(
            'comments',
            ['type' => 'app' . '\modules\blog\models\Post'],
            'type = :old_type',
            [':old_type' => 'app' . '\modules\blog\models\BlogPost']
        );
        return true;
    }

    public function safeDown(): bool
    {
        $this->update(
            'comments',
            ['type' => 'app' . '\modules\blog\models\BlogPost'],
            'type = :old_type',
            [':old_type' => 'app' . '\modules\blog\models\Post']
        );
        return true;
    }
}
