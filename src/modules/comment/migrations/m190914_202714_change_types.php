<?php

use app\extensions\migrate\EDbMigration;

class m190914_202714_change_types extends EDbMigration
{
    public function safeUp()
    {
        $this->update('{{comment}}',
            ['type' => 'app' . '\modules\blog\models\BlogPost'],
            'type = :old_type',
            [':old_type' => 'BlogPost']
        );
    }

    public function safeDown()
    {
        $this->update(
            '{{comment}}',
            ['type' => 'BlogPost'],
            'type = :old_type',
            [':old_type' => 'app' . '\modules\blog\models\BlogPost']
        );
    }
}
