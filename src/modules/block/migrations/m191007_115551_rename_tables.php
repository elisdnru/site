<?php

use yii\db\Migration;

class m191007_115551_rename_tables extends Migration
{
    public function safeUp()
    {
        $this->renameTable('{{block}}', 'blocks');
    }

    public function safeDown()
    {
        $this->renameTable('blocks', '{{block}}');
    }
}
