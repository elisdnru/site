<?php

class m181022_130712_remove_address extends EDbMigration
{
    public function safeUp()
    {
        $this->dropColumn('{{user}}', 'zip');
        $this->dropColumn('{{user}}', 'address');
        $this->dropColumn('{{user}}', 'phone');
        $this->dropColumn('{{user}}', 'googleplus');
    }

    public function safeDown()
    {
        $this->addColumn('{{user}}', 'zip', 'varchar(255) NOT NULL');
        $this->addColumn('{{user}}', 'address', 'text NOT NULL');
        $this->addColumn('{{user}}', 'phone', 'varchar(255) NOT NULL');
        $this->addColumn('{{user}}', 'googleplus', 'varchar(255) NOT NULL AFTER site');
    }
}