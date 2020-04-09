<?php

use yii\db\Migration;

class m190806_190155_remove_gallery_tables extends Migration
{
    public function safeUp()
    {
        if ($this->getDb()->getTableSchema('{{new}}')) {
            $this->dropColumn('{{new}}', 'gallery_id');
        }

        $this->dropColumn('{{blog_post}}', 'gallery_id');

        if ($this->getDb()->getTableSchema('{{gallery_photo}}')) {
            $this->dropTable('{{gallery_photo}}');
            $this->dropTable('{{gallery_category}}');
        }
    }

    public function safeDown()
    {
        echo "m181022_112914_remove_modules_table does not support migration down.\n";
        return false;
    }
}
