<?php
// phpcs:disable
// PSR1.Classes.ClassDeclaration.MissingNamespace

use yii\db\Migration;

class m130328_130712_create_user extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{user}}', [
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'username' => 'varchar(255) NOT NULL',
            'password' => 'varchar(255) NOT NULL',
            'salt' => 'varchar(255) NOT NULL',
            'email' => 'varchar(255) NOT NULL',
            'identity' => 'varchar(255) NOT NULL',
            'network' => 'varchar(255) NOT NULL',
            'confirm' => 'varchar(255) NOT NULL',
            'last_active' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            'create_datetime' => 'datetime NOT NULL',
            'last_modify_datetime' => 'datetime NOT NULL',
            'last_visit_datetime' => 'datetime NOT NULL',
            'avatar' => 'varchar(255) NOT NULL',
            'role' => 'varchar(64) NOT NULL',
            'active' => 'tinyint(1) NOT NULL DEFAULT 1',
            'lastname' => 'varchar(255) DEFAULT NULL',
            'name' => 'varchar(255) DEFAULT NULL',
            'middlename' => 'varchar(255) DEFAULT NULL',
            'zip' => 'varchar(255) NOT NULL',
            'address' => 'text NOT NULL',
            'phone' => 'varchar(255) NOT NULL',
            'site' => 'varchar(255) NOT NULL',
            'comments_count' => 'int(11) NOT NULL',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('username', '{{user}}', 'username');
        $this->createIndex('role', '{{user}}', 'role');
        $this->createIndex('active', '{{user}}', 'active');
        $this->createIndex('comments_count', '{{user}}', 'comments_count');
    }

    public function safeDown()
    {
        $this->dropTable('{{user}}');
    }
}
