<?php

use yii\db\Migration;

class m181022_141825_remove_unused_blocks extends Migration
{
    public function safeUp(): bool
    {
        $this->delete('{{block}}', ['in', 'alias', [
            'header',
            'footer',
            'copyright',
        ]]);
        return true;
    }

    public function safeDown(): bool
    {
        echo "m180806_112238_remove_unused_configs does not support migration down.\n";
        return false;
    }
}
