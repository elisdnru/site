<?php

use app\extensions\migrate\EDbMigration;

class m191023_111426_remove_comments_count extends EDbMigration
{
    public function safeUp()
    {
        $this->dropColumn('users', 'comments_count');
    }

    public function safeDown()
    {
        $this->addColumn('users', 'comments_count', 'int(11) NOT NULL');
        $this->createIndex('comments_count', 'users', 'comments_count');
    }
}
