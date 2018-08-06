<?php

class m130717_065918_add_author_link extends EDbMigration
{
    public function safeUp()
    {
        $this->addColumn('{{user}}', 'googleplus', 'varchar(255) NOT NULL AFTER site');
    }

    public function safeDown()
    {
        $this->dropColumn('{{user}}', 'googleplus');
    }
}
