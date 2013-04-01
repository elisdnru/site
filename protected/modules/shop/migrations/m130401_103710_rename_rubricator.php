<?php

class m130401_103710_rename_rubricator extends EDbMigration
{
    public function safeUp()
    {
        $this->dropIndex('rubrika_id', '{{shop_product}}');
        $this->renameColumn('{{shop_product}}', 'rubrika_id', 'rubric_id');
        $this->createIndex( 'rubric_id', '{{shop_product}}', 'rubric_id');
    }

    public function safeDown()
    {
        $this->dropIndex('rubric_id', '{{shop_product}}');
        $this->renameColumn('{{shop_product}}', 'rubric_id', 'rubrika_id');
        $this->createIndex( 'rubrika_id', '{{shop_product}}', 'rubrika_id');
    }
}