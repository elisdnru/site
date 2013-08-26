<?php

class m130722_062709_create_graduate extends EDbMigration
{
    public function safeUp()
    {
        $this->createTable('{{graduate_graduate}}', array(
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'grade_id' => 'int(11) NOT NULL',
            'firstname' => 'varchar(255) NOT NULL',
            'middlename' => 'varchar(255) NOT NULL',
            'lastname' => 'varchar(255) NOT NULL',
            'link' => 'varchar(255) NOT NULL',
            'reward' => 'tinyint(1) NOT NULL',
            'public' => 'tinyint(1) NOT NULL',
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('grade_id', '{{graduate_graduate}}', 'grade_id');

        $this->createIndex('public', '{{graduate_graduate}}', 'public');
    }

    public function safeDown()
    {
        $this->dropTable('{{graduate_graduate}}');
    }
}