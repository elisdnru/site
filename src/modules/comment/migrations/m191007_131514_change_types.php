<?php

use app\extensions\migrate\EDbMigration;

class m191007_131514_change_types extends EDbMigration
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
