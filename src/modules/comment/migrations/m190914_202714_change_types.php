<?php
// phpcs:disable
// PSR1.Classes.ClassDeclaration.MissingNamespace

use yii\db\Migration;

class m190914_202714_change_types extends Migration
{
    public function safeUp()
    {
        $this->update(
            '{{comment}}',
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
