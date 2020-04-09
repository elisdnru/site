<?php

use yii\db\Migration;

class m191007_115553_rename_tables extends Migration
{
    public function safeUp()
    {
        $this->renameTable('{{comment}}', 'comments');
    }

    public function safeDown()
    {
        $this->renameTable('comments', '{{comment}}');
    }
}
