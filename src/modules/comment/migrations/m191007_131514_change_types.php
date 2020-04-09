<?php

use yii\db\Migration;

class m191007_131514_change_types extends Migration
{
    public function safeUp()
    {
        $this->update(
            'comments',
            ['type' => 'app' . '\modules\blog\models\Post'],
            'type = :old_type',
            [':old_type' => 'app' . '\modules\blog\models\BlogPost']
        );
    }

    public function safeDown()
    {
        $this->update(
            'comments',
            ['type' => 'app' . '\modules\blog\models\BlogPost'],
            'type = :old_type',
            [':old_type' => 'app' . '\modules\blog\models\Post']
        );
    }
}
