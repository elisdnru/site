<?php

use yii\db\Migration;

class m190806_190155_remove_gallery_tables extends Migration
{
    public function safeUp(): bool
    {
        if ($this->getDb()->getTableSchema('{{new}}')) {
            $this->dropColumn('{{new}}', 'gallery_id');
        }

        if ($this->getDb()->getTableSchema('{{gallery_photo}}')) {
            $this->dropTable('{{gallery_photo}}');
            $this->dropTable('{{gallery_category}}');
        }
        return true;
    }

    public function safeDown(): bool
    {
        echo "m181022_112914_remove_modules_table does not support migration down.\n";
        return false;
    }
}
