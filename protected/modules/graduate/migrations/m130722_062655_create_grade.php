<?php

class m130722_062655_create_grade extends EDbMigration
{
    public function safeUp()
    {
        $this->createTable('{{graduate_grade}}', array(
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'year' => 'int(4) NOT NULL',
            'number' => 'varchar(2) NOT NULL',
            'letter' => 'varchar(1) NOT NULL',
            'teacher' => 'varchar(255) NOT NULL',
            'image' => 'varchar(255) NOT NULL',
        ), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8');

        $this->createIndex('year', '{{graduate_grade}}', 'year');
        $this->createIndex('number', '{{graduate_grade}}', 'number');
        $this->createIndex('letter', '{{graduate_grade}}', 'letter');
    }

    public function safeDown()
    {
        $this->dropTable('{{graduate_grade}}');
    }
}