<?php
// phpcs:disable
// PSR1.Classes.ClassDeclaration.MissingNamespace

use app\extensions\migrate\EDbMigration;

class m191025_144021_create_landing extends EDbMigration
{
    public function safeUp()
    {
        $this->createTable('landings', [
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'alias' => 'varchar(255) NOT NULL',
            'title' => 'varchar(255) NOT NULL',
            'text' => 'mediumtext NOT NULL',
            'system' => 'tinyint(1) NOT NULL',
            'parent_id' => 'int(11) DEFAULT NULL',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('landings_alias', 'landings', 'alias');
        $this->createIndex('landings_parent_id', 'landings', 'parent_id');
        $this->addForeignKey('landings_parent', 'landings', 'parent_id', 'landings', 'id');
    }

    public function safeDown()
    {
        $this->dropForeignKey('landings_parent', 'landings');
        $this->dropTable('landings');
    }
}
