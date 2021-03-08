<?php

use yii\db\Migration;

class m190914_202714_change_types extends Migration
{
    public function safeUp(): bool
    {
        $this->update(
            '{{comment}}',
            ['type' => 'app' . '\modules\blog\models\BlogPost'],
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
            [':old_type' => 'app' . '\modules\blog\models\BlogPost']
        );
        return true;
    }
}
