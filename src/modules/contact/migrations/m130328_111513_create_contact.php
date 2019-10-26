<?php
// phpcs:disable
// PSR1.Classes.ClassDeclaration.MissingNamespace

use app\extensions\migrate\EDbMigration;

class m130328_111513_create_contact extends EDbMigration
{
    public function safeUp()
    {
        $this->createTable('{{contact}}', [
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'pagetitle' => 'varchar(255) NOT NULL',
            'date' => 'datetime NOT NULL',
            'name' => 'varchar(200) NOT NULL',
            'email' => 'varchar(100) NOT NULL',
            'phone' => 'varchar(100) NOT NULL',
            'text' => 'text NOT NULL',
            'label' => 'text NOT NULL',
            'status' => 'varchar(100) NOT NULL',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('date', '{{contact}}', 'date');
        $this->createIndex('status', '{{contact}}', 'status');
    }


    public function safeDown()
    {
        $this->dropTable('{{contact}}');
    }
}
